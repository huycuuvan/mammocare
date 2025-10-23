<?php
namespace frontend\controllers;
use backend\models\Booking;
use backend\models\CatDoctor;
use backend\models\Supporter;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\EntryForm;
use frontend\models\OrderForm;
use frontend\models\MemberForm;
use frontend\models\ShopCart;
use frontend\models\HostingCart;
use frontend\models\EmailCart;
use yii\data\Pagination;
use backend\models\Product;
use backend\models\Cat;
use backend\models\News;
use backend\models\Page;
use backend\models\CatNews;
use backend\models\Album;
use backend\models\Menu;
use backend\models\Configure;
use backend\models\Contact;
use backend\models\Language;
use backend\models\Tab;
use backend\models\Office;
use backend\models\City;
use backend\models\ContactCustomer;
use backend\models\Message;
use backend\models\Buyer;
use backend\models\Video;
use backend\models\Partner;
use backend\models\Seo;
use backend\models\Province;
use backend\models\District;
use backend\models\Ward;
use backend\models\CatProfile;
use backend\models\Profile;
use backend\components\MyExt;
use yii\web\NotFoundHttpException;
use frontend\models\SubscribeForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $menu=0;
    public $conf;
    public $cont;
    public $info;
    public $lang;
    public $arrViewVars = [];
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        //Get Language
        $session = Yii::$app->session;
        if (!$session->has('language')) {
            $lang = Language::find()
                ->where(['active' => 1])
                ->orderBy(['defa' => SORT_DESC])
                ->one();
            if (!empty($lang)) {
                $session->set('language', $lang->code);
            }
        } else {
            $lang = Language::find()
                ->where(['active' => 1, 'code' => $session->get('language')])
                ->one();
        }
        $this->lang = $lang;
        Yii::$app->language = $session->get('language');
        $this->conf = Configure::getConfigure();
        $this->cont = Contact::getContact();
        $this->info = Tab::getTabs();
        $this->addToView('conf', $this->conf);
        $this->addToView('cont', $this->cont);
        $this->addToView('info', $this->info);
        $this->addToView('lang', $this->lang);
        Yii::$app->view->on(\yii\web\View::EVENT_BEGIN_BODY, function () {
            echo $this->conf->body_tag;
        });
        Yii::$app->view->on(\yii\web\View::EVENT_END_BODY, function () {
            echo $this->conf->closed_body_tag;
            if (!empty($this->conf->phone_widget)) {
                echo Yii::$app->controller->renderPartial('pages/_phone', ['cont' => $this->cont, 'conf' => $this->conf], true);
            }
            if (!empty($this->conf->hotline_widget)) {
                echo Yii::$app->controller->renderPartial('pages/_hotline', ['cont' => $this->cont, 'conf' => $this->conf], true);
            }
            echo Yii::$app->controller->renderPartial('pages/_subscribe', ['cont' => $this->cont, 'conf' => $this->conf], true);
        });
        $this->view->params['cont'] = $this->cont;
        $this->view->params['conf'] = $this->conf;
        $this->view->params['info'] = $this->info;
        $this->view->params['lang'] = $this->lang;
        Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($this->cont->logo);
        Yii::$app->params['og_title'] = $this->cont->site_title;
        Yii::$app->params['og_description'] = $this->cont->site_desc;
        $seo = Seo::getSeo(Seo::HOME_PAGE);
        if (!empty($seo)) {
            Yii::$app->params['og_image'] = Yii::$app->urlManager->createAbsoluteUrl($seo->path);
            Yii::$app->params['og_title'] = $seo->site_title;
            Yii::$app->params['og_description'] = $seo->site_desc;
        }
        Yii::$app->params['canonical'] = 'http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . $_SERVER['HTTP_HOST'];
        if (Yii::$app->session->get('show_product')) {
            $this->view->params['show_product'] = Yii::$app->session->get('show_product');
        }
        return parent::beforeAction($action);
    }
    protected function addToView($sVarName, $mxVarVal)
    {
        $this->arrViewVars[$sVarName] = $mxVarVal;
    }
    //Extend render from some variable
    public function render($view, $params = array())
    {
        $params = array_merge($this->arrViewVars, $params);
        return parent::render($view, $params);
    }
    private function setBigTitle($title, $header = false)
    {
        $this->view->params['big-title'] = $title;
        $this->view->params['big-header'] = $header;
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->params['index']=1;
        $menu= Menu::find()->where('type like "1:1" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
        }
        return $this->render('index', [
        ]);
    }
    public function actionChangeLang($code)
    {
        $session = Yii::$app->session;
        $session->set('language', $code);
        Yii::$app->language = $session->get('language');
        return $this->redirect(Yii::$app->homeUrl);
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $this->setBigTitle(Yii::t('app', 'login'));
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('member/login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        Yii::$app->params['canonical'] .=Url::to(['site/contact']);
        $this->setBigTitle(Yii::t('app', 'contact'), true);
        $menu= Menu::find()->where('type like "1:2" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
        }
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $subject = Yii::t('app', 'contact') . ': ' . $model->subject;
            $arrInfo = [
                Yii::t('app', 'fullname') => $model->name,
                Yii::t('app', 'email') => $model->email,
                Yii::t('app', 'phone') => $model->phone,
                Yii::t('app', 'subject') => $model->subject,
                Yii::t('app', 'message') => $model->body,
            ];
            $content = '<h1>' . Yii::t('app', 'contact') . '</h1>';
            foreach ($arrInfo as $key => $value) {
                $content .= '<p><strong>' . $key. ':</strong> ' . nl2br($value) . '</p>';
            }
            if (isset($_POST['g-recaptcha-response'])) {
                $captcha=$_POST['g-recaptcha-response'];
            }
            if (MyExt::sendMail($this->cont->email, $subject, $content)) {
                $record = new ContactCustomer();
                $record->name = $model->name;
                $record->email = $model->email;
                $record->mobile = $model->phone;
                $record->title = $model->subject;
                $record->content = $model->body;
                if ($record->validate()) {
                    $record->save();
                }
                Yii::$app->session->setFlash('contact', Yii::t('app', 'contact-msg-success'));
            } else {
                Yii::$app->session->setFlash('contact', Yii::t('app', 'contact-msg-error'));
            }
            return $this->render('contact', [
                'model' => $model,
            ]);
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }
    public function actionAddtocart()
    {
        $request = Yii::$app->request;
        $id = intval($request->get('id'));
        $product = Product::findOne($id);
        if (empty($product) || $product->active != 1) {
            throw new NotFoundHttpException();
        }
        $quantity = intval($request->post('quantity'));
        if ($quantity < 1)
            $quantity = 1;
        $option=0;
        $arrOptions = [];
        if($product->options )
            foreach ($product->options as $row) {
                $arrOptions[$row->property->name][] = $row;
            }
        $string=[];
        $arr=[];
        if(!empty($arrOptions)){
            foreach ($arrOptions as $titleGroup => $optionGroup) {
                $dem=0;$d=0;
                foreach ($optionGroup as $row){
                    $c=0;
                    if($d==0) array_push($arr,$row->id);
                    if($row->propertyValue) {
                        if($c==0) array_push($string,$row->property_value_id);
                        $dem++;
                        $c++;
                    }
                    $d++;
                }
            }
        }
        $price=$product->sale?$product->sale:0;
        if(!empty($string)){
            $option = implode('-',$arr);
            $find_product=PropertyPrice::find()->where(['product_id'=>$product->id,'property_string'=>implode('-',$string)])->one();
            if(!empty($find_product))
                $price=$find_product->price;
        }
        $option.='/'.$price;
        $cart = \Yii::$app->cart;
        $cart->add($product, $quantity, $option);
        return $this->redirect(['site/shopping-order']);
    }
    /* BEGIN: Shopping and Order */
    public function actionAddcart()
    {
        $request = Yii::$app->request;
        $id = intval($request->post('id'));
        $product = Product::findOne($id);
        if (empty($product) || $product->active != 1) {
            throw new NotFoundHttpException();
        }
        $quantity = intval($request->post('quantity'));
        if ($quantity < 1) {
            $quantity = 1;
        }
        $cart = \Yii::$app->cart;
        $cart->add($product, $quantity);
        return $this->redirect(['site/shopping-order']);
    }
    public function actionRemovecart($id)
    {
        $cart = \Yii::$app->cart;
        $cart->remove($id);
        return $this->redirect(['site/shopping-order']);
    }
    public function actionDeletecart()
    {
        $cart = \Yii::$app->cart;
        $cart->clear();
        return $this->redirect(['site/shopping-order']);
    }
    public function actionChangecart()
    {
        $request = Yii::$app->request;
        $id = intval($request->post('id'));
        $product = Product::findOne($id);
        if (empty($product) || $product->active != 1) {
            throw new NotFoundHttpException();
        }
        $quantity = intval($request->post('quantity'));
        if ($quantity < 1) {
            $quantity = 1;
        }
        $cart = \Yii::$app->cart;
        $cart->change($product->id, $quantity);
        return  '"'.MyExt::formatPrice($cart->getTotalCost()).'"';
    }
    public function actionShoppingCart()
    {
        return $this->redirect(Url::to(['site/shopping-order']));
    }
    public function actionShoppingOrder()
    {
        $this->setBigTitle(Yii::t('app', 'shopping-order'), true);
        $model = new OrderForm();
        $cart = \Yii::$app->cart;
        if (!empty($cart->getItems()) && $model->load(Yii::$app->request->post()) && $model->validate()) {
            $record = new Buyer();
            $diachi=$model->address.', '.Ward::findOne($model->ward)->name.', '.District::findOne($model->district)->name.', '.Province::findOne($model->province)->name;
            $record->fullname = $model->fullname;
            $record->mobile = $model->phone;
            $record->email = $model->email;
            $record->content = $model->content;
            $record->address = $diachi;
            $record->total_price = MyExt::formatPrice($cart->getTotalCost());
            $record->ordered_time = date("Y-m-d H:i:s");
            $record->type_id =  $model->type_id;
            $itemTable = '
            <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; border-width:1px; width:100%">
              <thead>
                <tr>
                  <th style="width:60px;padding: 5px;">STT</th>
                  <th style="padding: 5px;">' . Yii::t('app', 'product') . '</th>
                  <th style="padding: 5px;">' . Yii::t('app', 'price') . '</th>       
                  <th style="padding: 5px;">Số lượng</th>    
                  <th style="padding: 5px;">Tổng</th>
                </tr>
              </thead>';
            $itemTable .= '<tbody>';
            $stt=1;
            foreach ($cart->getItems() as $row) {
                $product = $row->getProduct();
                $itemTable .= '<tr>
                    <td style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:left;padding: 5px;">' . $stt . ' </td>
                    <td style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:left;padding: 5px;">'.Html::a($product->name, $product->getUrl(), ['target'=>'_blank']).'</td>
                    <td style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:left;padding: 5px;">' . MyExt::formatPrice($row->getPrice()) . ' </td>
                    <td style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:center;padding: 5px;">' .$row->getQuantity() . '</td>
                    <td style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:center;padding: 5px;">' .MyExt::formatPrice($row->getCost()) . '</td>
                  </tr>';
                $stt++;
            }
            $itemTable .= '<tr>
              <td colspan="3" style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:right;padding: 5px;"><strong>' . Yii::t('app', 'shopping-total') . '</strong></td>
              <td colspan="2" style="border-color:#dddddd; border-style:solid; border-width:1px; text-align:left;padding: 5px;">' . MyExt::formatPrice($cart->getTotalCost()) . '</td>
            </tr>';
            $itemTable .= '</tbody></table>';
            $record_type=$record->type_id==1?'Thanh toán khi giao hàng':'Chuyển khoản qua ngân hàng';
            $record->bill_json = '';
            if ($record->validate() && $record->save()) {
                $msg = Message::getMessage(Message::SHOPCART, [
                    '{id}' => $record->id,
                    '{date}' => $record->ordered_time,
                    '{website}' => Url::base(true),
                    '{fullname}' => $record->fullname,
                    '{email}' => $record->email,
                    '{phone}' => $record->mobile,
                    '{address}' => $diachi,
                    '{type}'=>$record_type,
                    '{table-order}' => $itemTable,
                ]);
                $record->bill_json = $msg['content'];
                $record->save();
                //Start send mai;
                if (MyExt::sendMail($this->cont->email, $msg['title'], $msg['content'])) {
                    Yii::$app->session->setFlash('order', Yii::t('app', 'order-msg-success'));
                    MyExt::sendMail($record->email, $msg['title'], $msg['content']);
                    $cart->clear();
                } else {
                    Yii::$app->session->setFlash('order', Yii::t('app', 'order-msg-error'));
                }
                return $this->redirect(['site/shopping-thanks','order_id'=>$record->id]);
            }
        } else {
            return $this->render('shop/shopping-order', [
                'model' => $model
            ]);
        }
    }
    public function actionShoppingThanks($order_id)
    {
        $this->setBigTitle('Đặt hàng thành công', true);
        return $this->render('shop/shopping-thanks', [
            'order_id' => $order_id
        ]);
    }
    /* END: Shopping and Order */
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        $this->setBigTitle(Yii::t('app', 'signup'));
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->setFlash('signup', Yii::t('app', 'member-success-reg'));
                return $this->refresh();
            }
        }
        return $this->render('member/signup', [
            'model' => $model,
        ]);
    }
    /**
     * @return mixed
     */
    public function actionActiveAccount($token)
    {
        $model = User::findByVerificationToken($token);
        if (!empty($model) && $model->active != 1) {
            $model->active = 1;
            $model->verification_token = '';
            $model->save();
            Yii::$app->session->setFlash('signup', Yii::t('app', 'member-success-active'));
        } else {
            return $this->redirect(Url::home());
        }
        return $this->render('member/signup', [
            'member' => $model
        ]);
    }
    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        $title = Yii::t('app', 'member-password-reset');
        $this->setBigTitle($title);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('reset', Yii::t('app', 'member-reset-request-ok'));
            } else {
                Yii::$app->session->setFlash('reset', Yii::t('app', 'member-reset-request-err'));
            }
            return $this->refresh();
        }
        return $this->render('member/requestPasswordResetToken', [
            'model' => $model,
            'title' => Yii::t('app', 'member-password-reset')
        ]);
    }
    /**
     * Requests Verification Email
     *
     * @return mixed
     */
    public function actionRequestVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        $title = Yii::t('app', 'member-verification-email');
        $this->setBigTitle($title);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('reset', Yii::t('app', 'member-verify-request-ok'));
            } else {
                Yii::$app->session->setFlash('reset', Yii::t('app', 'member-verify-request-err'));
            }
            return $this->refresh();
        }
        return $this->render('member/resendVerificationEmail', [
            'model' => $model,
            'title' => $title
        ]);
    }
    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        $title = Yii::t('app', 'member-password-reset');
        $this->setBigTitle($title);
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', Yii::t('app', 'member-reset-password-ok'));
            return $this->goHome();
        }
        return $this->render('member/resetPassword', [
            'model' => $model,
            'title' => $title
        ]);
    }
    public function actionMemberInformation()
    {
        $userId = Yii::$app->user->identity->id;
        $title = Yii::t('app', 'member-information');
        $user = \backend\models\User::findIdentity($userId);
        $model = new MemberForm();
        $model->scenario = MemberForm::SCENARIO_INFO;
        $this->setBigTitle($title);
        $model->username = $user->username;
        $model->fullname = $user->fullname;
        $model->email = $user->email;
        $model->mobile = $user->mobile;
        $model->address = $user->address;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->fullname = $model->fullname;
            $user->mobile = $model->mobile;
            $user->address = $model->address;
            if ($user->save()) {
                Yii::$app->session->setFlash('update', Yii::t('app', 'member-information-update-ok'));
            }
            return $this->refresh();
        }
        return $this->render('member/account-info', [
            'model' => $model,
            'title' => $title
        ]);
    }
    public function actionMemberChangePassword()
    {
        $userId = Yii::$app->user->identity->id;
        $title = Yii::t('app', 'member-change-password');
        $user = \backend\models\User::findIdentity($userId);
        $model = new MemberForm();
        $model->scenario = MemberForm::SCENARIO_PASS;
        $this->setBigTitle($title);
        $model->password_hash = $user->password_hash;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user->setPassword($model->password);
            if ($user->save()) {
                Yii::$app->session->setFlash('update', Yii::t('app', 'member-reset-password-ok'));
            }
            return $this->refresh();
        }
        return $this->render('member/account-change-pass', [
            'model' => $model,
            'title' => $title
        ]);
    }
    public function actionAllProduct()
    {
        $query = Product::find()->where(['active' => 1]);
        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);
        $product_list = $query->orderBy(['id' => SORT_DESC])->offset($pagination->offset)
            ->limit($pagination->limit)->all();
        return $this->render('pages/all-product', [
            'product_list' => $product_list,
            'pagination' => $pagination,
        ]);
    }
    public function actionListProduct($id = '', $name = '')
    {
        $conditions = [];
        $titleBig = Yii::t('app', 'products');
        //add menu nếu có k có cat ( all products )
        $menu= Menu::find()->where('type like "1:4" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
            if ($menu->parent!=0) {
                $this->view->params['menu-id']=$menu->parent;
            }
        }
        if (!empty($id) && !empty($name)) {
            $model = Cat::findOne($id);
            if (empty($model)) {
                throw new NotFoundHttpException();
            }
            $correct_url=$model->getUrl();
            Yii::$app->params['canonical'] .=$correct_url;
            $current_url=$_SERVER['REQUEST_URI'];
            if (!strstr($current_url, $correct_url)) {
                return $this->redirect($correct_url, 301);
            }
            $titleBig = $model->name;
            $arr_subcat[]=$model->id;
            $subcat=$model->getSubAdmin();
            if (!empty($subcat)) {
                foreach ($subcat as $row) {
                    $arr_subcat[] = $row->id;
                    $subcat1=$row->getSubAdmin();
                    if (!empty($subcat1)) {
                        foreach ($subcat1 as $row1) {
                            $arr_subcat[] = $row1->id;
                        }
                    }
                }
            }
            //add menu nếu có id cat
            $menu= Menu::find()->where('type like "4:'.$id.'" and position=1')->one();
            if (!empty($menu)>0) {
                $this->view->params['menu-id']=$menu->id;
                $this->view->params['menu-active']=$menu->id;
                if ($menu->parent!=0) {
                    $this->view->params['menu-id']=$menu->parent;
                }
            }
            $conditions['{{product}}.active'] = 1;
            $conditions['{{language}}.code'] = Yii::$app->language;
            $query = Product::find()->where($conditions)->andWhere('category_id in ('. implode(',', $arr_subcat).')')->joinWith(['language', 'catProduct'])->distinct();
        }
        else {
            $conditions['{{product}}.active'] = 1;
            $conditions['{{language}}.code'] = Yii::$app->language;
            $query = Product::find()->where($conditions)->joinWith(['language', 'catProduct'])->distinct();
        }
        $query->orderBy(['ord' => SORT_ASC,'id'=>SORT_DESC]);
        if (isset($_GET['sort_by'])) {
            if ($_GET['sort_by']=='news') {
                $query->orderBy('id desc');
            }
            if ($_GET['sort_by']=='price-ascending') {
                $query->orderBy('sale asc');
            }
            if ($_GET['sort_by']=='price-descending') {
                $query->orderBy('sale desc');
            }
            if ($_GET['sort_by']=='name-az') {
                $query->orderBy('name asc');
            }
            if ($_GET['sort_by']=='name-za') {
                $query->orderBy('name desc');
            }
        }
        $pagination = new Pagination([
            'defaultPageSize' => $this->conf->prod_per_page,
            'totalCount' => $query->count(),
        ]);
        $product_list = $query->offset($pagination->offset)
            ->limit($pagination->limit)->all();
        $this->setBigTitle($titleBig, true);
        return $this->render('pages/list-product', [
            'cat' => !empty($model) ? $model : false,
            'product_list' => $product_list,
            'title' => $titleBig,
            'pagination' => $pagination,
        ]);
    }
    public function actionListProductByBrand($id, $name)
    {
        $model = Cat::findOne($id);
        $query = Product::find()->where(['cat_id' => $model->id, 'active' => 1]);
        $pagination = new Pagination([
            'defaultPageSize' => 15,
            'totalCount' => $query->count(),
        ]);
        $product_list = $query->orderBy(['id' => SORT_DESC])->offset($pagination->offset)
            ->limit($pagination->limit)->all();
        return $this->render('pages/list-product-by-brand', [
            'model' => $model,
            'product_list' => $product_list,
            'pagination' => $pagination,
        ]);
    }
    public function actionProduct($id, $name)
    {
        $model = Product::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        $model->hits += 1;
        $model->save();
        $this->setBigTitle($model->category->name);
        return $this->render('pages/product', [
            'model' => $model
        ]);
    }
    public function actionListNews($id, $name)
    {
        $model = CatNews::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        } else {
            $lang = Language::find()
                ->where(['id' => $model->lang_id ])
                ->one();
            if (!empty($lang)) {
                $this->lang = $lang;
                Yii::$app->language = $lang->code;
            }
        }
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        if (!strstr($current_url, $correct_url)) {
            return $this->redirect($correct_url, 301);
        } else {
            $arr_subcat[]=$model->id;
            $subcat=$model->getSubCat();
            if (!empty($subcat)) {
                foreach ($subcat as $row) {
                    $arr_subcat[] = $row->id;
                }
            }
            $query = News::find()->where(['active' => 1]);
            $query->andWhere('cat_id in ('. implode(',', $arr_subcat).')');
            $pagination = new Pagination([
                'defaultPageSize' => $this->conf->news_per_page,
                'totalCount' => $query->count(),
            ]);
            $news_list = $query->orderBy(['created_at'=>SORT_DESC, 'id' => SORT_DESC])->offset($pagination->offset)
                ->limit($pagination->limit)->all();
            $menu= Menu::find()->where('type like "3:'.$id.'" and position=1')->one();
            if (!empty($menu)>0) {
                $this->view->params['menu-id']=$menu->id;
                $this->view->params['menu-active']=$menu->id;
                if ($menu->parent!=0) {
                    $this->view->params['menu-id']=$menu->parent;
                }
            }
            $this->setBigTitle($model->name, true);
            return $this->render('pages/list-news', [
                'model' => $model,
                'news_list' => $news_list,
                'pagination' => $pagination,
            ]);
        }
    }
    public function actionSearchNews($keyword)
    {
        $keyword = strip_tags($keyword);
        Yii::$app->params['canonical'] .= Url::to(['site/search-news', 'keyword' => $keyword]);
        if (!empty($keyword)){
            $query = News::find()->joinWith(['language']);
            $query->andWhere(['like', 'title', $keyword]);
            $query->andWhere(['{{news}}.active' => 1]);
            $query->andWhere(['{{language}}.code' => Yii::$app->language]);
            $count = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => $this->conf->news_per_page,
                'totalCount' => $query->count(),
            ]);
            $news_list = $query->orderBy(['created_at'=>SORT_DESC,'id' => SORT_DESC])
                ->offset($pagination->offset)
                ->limit($pagination->limit)->all();
            $this->setBigTitle(Yii::t('app', 'search'));
            return $this->render('pages/search-news', [
                'count' => $count,
                'keyword' => $keyword,
                'news_list' => $news_list,
                'pagination' => $pagination,
            ]);
        }
        else
            return $this->redirect(Url::home());
    }
    public function actionSearchProduct($keyword)
    {
        $keyword = strip_tags($keyword);
        Yii::$app->params['canonical'] .= Url::to(['site/search-news', 'keyword' => $keyword]);
        if (!empty($keyword)){
            $query = Product::find()->joinWith(['language']);
            $query->andWhere(['like', '{{product}}.name', $keyword]);
            $query->andWhere(['{{product}}.active' => 1]);
            $query->andWhere(['{{language}}.code' => Yii::$app->language]);
            $count = $query->count();
            $pagination = new Pagination([
                'defaultPageSize' => $this->conf->prod_per_page,
                'totalCount' => $query->count(),
            ]);
            $news_list = $query->orderBy(['created_at'=>SORT_DESC,'id' => SORT_DESC])
                ->offset($pagination->offset)
                ->limit($pagination->limit)->all();
            $this->setBigTitle(Yii::t('app', 'search'));
            return $this->render('pages/search-news', [
                'count' => $count,
                'keyword' => $keyword,
                'news_list' => $news_list,
                'pagination' => $pagination,
            ]);
        }
        else
            return $this->redirect(Url::home());
    }
    public function actionSearch()
    {
        return $this->redirect(Url::home(), 301);
    }
    public function actionNews( $id, $name)
    {
        $model = News::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        } else {
            $lang = Language::find()
                ->where(['id' => $model->lang_id ])
                ->one();
            if (!empty($lang)) {
                $this->lang = $lang;
                Yii::$app->language = $lang->code;
            }
        }
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        if ($current_url!=$correct_url) {
            return $this->redirect($correct_url, 301);
        }
        $menu= Menu::find()->where('type like "3:'.$model->cat_id.'" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
            if ($menu->parent!=0) {
                $this->view->params['menu-id']=$menu->parent;
            }
        }
        $model->hits += 1;
        $model->save();
        if (!empty($model->father)) {
            $this->setBigTitle($model->father->name);
        }
        return $this->render('pages/news', [
            'model' => $model
        ]);
    }
    public function actionPage($id, $name)
    {
        $model = Page::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        } else {
            $lang = Language::find()
                ->where(['id' => $model->lang_id ])
                ->one();
            if (!empty($lang)) {
                $this->lang = $lang;
                Yii::$app->language = $lang->code;
            }
        }
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        if ($current_url!=$correct_url) {
            return $this->redirect($correct_url, 301);
        }
        $menu= Menu::find()->where('type like "2:'.$model->id.'" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
            if ($menu->parent!=0) {
                $this->view->params['menu-id']=$menu->parent;
            }
        }
        $this->setBigTitle($model->title);
        return $this->render('pages/page', [
            'model' => $model
        ]);
    }
    public function actionSearchHome()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $_arr = [];
        if (!empty($_GET['keyword'])) {
            $model = Product::find()->where('active = 1 AND (name like "%'.$_GET['keyword'].'%" OR brief like "%'.$_GET['keyword'].'%" OR description like "%'.$_GET['keyword'].'%")')->limit(20)->all();
            if (!empty($model)) {
                foreach ($model as $row) {
                    $_arr[] = ['name' => $row->name, 'url' => Url::to(['site/product', 'id'=>$row->id, 'name'=>$row->url])];
                }
            }
        }
        return $_arr;
    }
    public function actionGallery()
    {
        $query = Album::find()->where(['{{album}}.active' => 1])->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->joinWith(['language']);
        $query->andWhere(['{{language}}.code' => Yii::$app->language]);
        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $query->count(),
        ]);
        $video_list = $query->orderBy(['ord'=>SORT_ASC,'id' => SORT_DESC])->offset($pagination->offset)
            ->limit($pagination->limit)->all();
        $this->setBigTitle(Yii::t('app', 'gallery'), true);
        $correct_url=Url::to(['site/gallery','page'=>1]);
        $current_url=$_SERVER['REQUEST_URI'];
        if (!strstr($current_url, $correct_url)) {
            return $this->redirect($correct_url, 301);
        }
        Yii::$app->params['canonical'] .=$correct_url;
        return $this->render('pages/gallery', [
            'model' => $video_list,
            'pagination' => $pagination,
        ]);
    }
    public function actionAlbum($id, $name)
    {
        $model = Album::findOne($id);
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        if ($current_url!=$correct_url) {
            return $this->redirect($correct_url, 301);
        }
        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $this->setBigTitle($model->name, true);
        return $this->render('pages/album', [
            'model' => $model
        ]);
    }
    public function actionVideo()
    {
        $query = Video::find()->where(['{{video}}.active' => 1])->orderBy(['ord' => SORT_ASC, 'id' => SORT_DESC])->joinWith(['language']);
        $query->andWhere(['{{language}}.code' => Yii::$app->language]);
        $pagination = new Pagination([
            'defaultPageSize' => 6,
            'totalCount' => $query->count(),
        ]);
        $video_list = $query->orderBy(['ord'=>SORT_ASC,'id' => SORT_DESC])->offset($pagination->offset)
            ->limit($pagination->limit)->all();
        $this->setBigTitle(Yii::t('app', 'video'), true);
        $correct_url=Url::to(['site/video','page'=>1]);
        $current_url=$_SERVER['REQUEST_URI'];
        if (!strstr($current_url, $correct_url)) {
            return $this->redirect($correct_url, 301);
        }
        Yii::$app->params['canonical'] .=$correct_url;
        return $this->render('pages/video', [
            'model' => $video_list,
            'pagination' => $pagination,
        ]);
    }
    public function actionGetInitMap()
    {
        $mapCenter = [@$this->info['map-latitude'], @$this->info['map-longitude'], @$this->info['map-zoom']];
        $agencyList = Office::getHomeOffice();
        $agency = [];
        foreach ($agencyList as $row) {
            $agency[] = [
                $row->latitude,
                $row->longitude,
                $row->title,
                $row->content
            ];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->asJson([
            'center' => $mapCenter,
            'agency' => $agency
        ]);
    }
    public function actionGetAgency($city_id)
    {
        $model = City::findOne($city_id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $mapCenter = [$model->latitude, $model->longitude, $model->zoom];
        $agencyList = Office::getOfficeByCity($city_id);
        $agency = [];
        foreach ($agencyList as $row) {
            $agency[] = [
                $row->latitude,
                $row->longitude,
                $row->title,
                $row->content
            ];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->asJson([
            'center' => $mapCenter,
            'agency' => $agency
        ]);
    }
    public function actionSubscribe()
    {
        $model = new SubscribeForm();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if ($model->load(Yii::$app->request->post())) {
            $model->scenario = $model->type;
            if ($model->validate()) {
                $title = strip_tags($this->info['enquiry-title']);
                $subject = $this->info['request-title'];
                if ($model->scenario == SubscribeForm::SCENARIO_ENQUIRY) {
                    $arrInfo = [
                        Yii::t('app', 'fullname') => $model->name,
                        Yii::t('app', 'email') => $model->email,
                        Yii::t('app', 'phone') => $model->phone,
                        Yii::t('app', 'company') => $model->company,
                        Yii::t('app', 'message') => $model->body
                    ];
                } else {
                    $arrInfo = [
                        Yii::t('app', 'fullname') => $model->name,
                        Yii::t('app', 'email') => $model->email,
                        Yii::t('app', 'phone') => $model->phone,
                        Yii::t('app', 'message') => $model->body
                    ];
                }
                $content = '<h1>' . $title . '</h1>';
                foreach ($arrInfo as $key => $value) {
                    if (!empty($value)) {
                        $content .= '<p><strong>' . $key. ':</strong> ' . nl2br($value) . '</p>';
                    }
                }
                if (MyExt::sendMail($this->cont->email, $subject, $content)) {
                    $msg = Yii::t('app', 'contact-msg-success');
                } else {
                    $msg = Yii::t('app', 'contact-msg-error');
                }
                return [
                    'success' => 1,
                    'msg' => $msg
                ];
            } else {
                return [
                    'success' => 0,
                    'msg' => $model->getErrors()
                ];
            }
        }
    }
    public function actionGetimg()
    {
        if (isset($_GET['id'])) {
            return $this->renderPartial('pages/_getimg', array(
                'id' => $_GET['id']
            ));
        } else {
            return 0;
        }
    }
    public function actionGetimgalbum()
    {
        if (isset($_GET['id'])) {
            return $this->renderPartial('pages/_getimgalbum', array(
                'id' => $_GET['id']
            ));
        } else {
            return 0;
        }
    }
    public function actionSavemail()
    {
        if (isset($_POST['mail'])) {
            if ($_POST['type']==1) {
                $nd="<p><strong>Đăng ký nhận tư vấn dịch vụ từ website ".$_POST['src']."</strong></p>";
            } else {
                $nd="<p><strong>Đăng ký nhận tư vấn dịch vụ từ website ".$_POST['src']."</strong></p>";
            }
            $nd.="<p><strong>Họ tên: ".$_POST['name']."</strong></p>";
            $nd.="<p><strong>Điện thoại: ".$_POST['phone']."</strong></p>";
            $nd.="<p><strong>Email: ".$_POST['mail']."</strong></p>";
            $nd.="<p><strong>Nội dung: ".$_POST['content']."</strong></p>";
            $subject='Đăng ký nhận thông tin';
            if (MyExt::sendMail($this->cont->email, $subject, $nd)) {
                $record = new ContactCustomer();
                $record->name = $_POST['name'];
                $record->email = $_POST['mail'];
                $record->mobile = $_POST['phone'];
                $record->title = 'Đăng ký nhận tư vấn dịch vụ';
                $record->content = $_POST['content'];
                if ($record->validate()) {
                    $record->save();
                }
                return 1;
            } else {
                return 0;
            }
        }
        return 123123123;
    }
    public function actionSaveformat()
    {
        if (isset($_GET['type'])) {
            $this->view->params['show_product']=$_GET['type'];
            Yii::$app->session->set('show_product', $_GET['type']);
            return $_GET['type'];
        } else {
            return 0;
        }
    }
    public function actionGetList()
    {
        if (!empty($_GET['text'])) {
            return Yii::$app->controller->renderPartial('pages/get-list', [
                'keyword' => $_GET['text']
            ]);
        }
    }
    public function actionGetdistrict()
    {
        $list_war='';
        $list_doctor='';
        if (!empty($_GET['province_id'])) {
            $list_war='';
        }
        $find_doctor=District::getDistrict($_GET['province_id']);
        if (!empty($find_doctor)) {
            foreach ($find_doctor as $dis) {
                $list_doctor.='<option value="'.$dis->id.'">'.$dis->name.'</option>';
            }
            $find_ward=Ward::getWard($find_doctor[0]->id);
            if (!empty($find_ward)) {
                foreach ($find_ward as $ward) {
                    $list_war.='<option value="'.$ward->id.'">'.$ward->name.'</option>';
                }
            }
        }
        return json_encode([
            'list_doctor'=>$list_doctor,
            'list_war'=>$list_war
        ]);
    }
    public function actionGetward()
    {
        $list_war='';
        $list_doctor='';
        if (!empty($_GET['district_id'])) {
            $find_ward=Ward::getWard($_GET['district_id']);
            if (!empty($find_ward)) {
                foreach ($find_ward as $ward) {
                    $list_war.='<option value="'.$ward->id.'">'.$ward->name.'</option>';
                }
            }
        }
        return json_encode([
            'list_war'=>$list_war
        ]);
    }
    public function actionListProfile()
    {
        $this->setBigTitle(Yii::t('app', 'crew'), true);
        $menu= Menu::find()->where('type like "1:8" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
        }
        $correct_url=Url::to(['site/list-profile','page'=>1]);
        Yii::$app->params['canonical'] .=$correct_url;
        $query = Profile::find()->where(['{{profile}}.active' => 1])->joinWith(['language'])->distinct();
        $query->andWhere(['{{language}}.code'=>Yii::$app->language]);
        $pagination = new Pagination([
            'defaultPageSize' => $this->conf->prod_per_page,
            'totalCount' => $query->count(),
        ]);
        $crews_list = $query->orderBy(['{{profile}}.ord'=>SORT_ASC, '{{profile}}.id' => SORT_DESC])->offset($pagination->offset)
            ->limit($pagination->limit)->all();
        return $this->render('pages/list-profile', [
            'crews_list' => $crews_list,
            'pagination' => $pagination,
        ]);
    }

    public function actionDoctors()
    {
        $this->setBigTitle('Đội ngũ bác sĩ', true);
        return $this->render('doctors');
    }

    public function actionTestDoctors()
    {
        return $this->render('doctors');
    }

    public function actionBooking()
    {
        $this->setBigTitle('Đặt lịch khám', true);
        return $this->render('booking');
    }

    public function actionBookingOnline()
    {
        $this->setBigTitle('Đặt lịch Online', true);
        
        $model = new \frontend\models\BookingForm();
        
        if ($model->load(Yii::$app->request->post())) {
            if ($model->sendBookingEmail()) {
                Yii::$app->session->setFlash('success', 'Đặt lịch thành công! Chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.');
                return $this->redirect(['site/booking-online']);
            } else {
                Yii::$app->session->setFlash('error', 'Có lỗi xảy ra khi đặt lịch. Vui lòng thử lại sau.');
            }
        }
        
        return $this->render('booking-online', [
            'model' => $model
        ]);
    }

    public function actionBookingPrepare()
    {
        $this->setBigTitle('Chuẩn bị khám', true);
        return $this->render('booking-prepare');
    }

    public function actionBookingProcess()
    {
        $this->setBigTitle('Quy trình khám', true);
        return $this->render('booking-process');
    }

    public function actionListDoctor($id,$name)
    {
        $model = CatDoctor::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        } else {
            $lang = Language::find()
                ->where(['id' => $model->lang_id ])
                ->one();
            if (!empty($lang)) {
                $this->lang = $lang;
                Yii::$app->language = $lang->code;
            }
        }
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        if (!strstr($current_url, $correct_url)) {
            return $this->redirect($correct_url, 301);
        } else {
            $arr_subcat[]=$model->id;
            $query = Supporter::find()->where(['{{supporter}}.active' => 1])->joinWith(['language'])->distinct();
            $query->andWhere(['{{language}}.code'=>Yii::$app->language]);
            $query->andWhere('job in ('. implode(',', $arr_subcat).')');
            $pagination = new Pagination([
                'defaultPageSize' => $this->conf->prod_per_page,
                'totalCount' => $query->count(),
            ]);
            $crews_list = $query->orderBy(['ord'=>SORT_ASC, 'id' => SORT_DESC])->offset($pagination->offset)
                ->limit($pagination->limit)->all();
            $menu= Menu::find()->where('type like "5:'.$id.'" and position=1')->one();
            if (!empty($menu)>0) {
                $this->view->params['menu-id']=$menu->id;
                $this->view->params['menu-active']=$menu->id;
                if ($menu->parent!=0) {
                    $this->view->params['menu-id']=$menu->parent;
                }
            }
            $this->setBigTitle($model->name, true);
            return $this->render('pages/list-doctor', [
                'model' => $model,
                'doctor_list' => $crews_list,
                'pagination' => $pagination,
            ]);
        }
    }
    public function actionDetail( $id, $name)
    {
        $model = Supporter::findOne($id);
        if (empty($model)) {
            throw new NotFoundHttpException();
        } else {
            $lang = Language::find()
                ->where(['id' => $model->lang_id ])
                ->one();
            if (!empty($lang)) {
                $this->lang = $lang;
                Yii::$app->language = $lang->code;
            }
        }
        $correct_url=$model->getUrl();
        Yii::$app->params['canonical'] .=$correct_url;
        $current_url=$_SERVER['REQUEST_URI'];
        if ($current_url!=$correct_url) {
            return $this->redirect($correct_url, 301);
        }
        $menu= Menu::find()->where('type like "5:'.$model->job.'" and position=1')->one();
        if (!empty($menu)>0) {
            $this->view->params['menu-id']=$menu->id;
            $this->view->params['menu-active']=$menu->id;
            if ($menu->parent!=0) {
                $this->view->params['menu-id']=$menu->parent;
            }
        }
        $this->setBigTitle($model->name);
        return $this->render('pages/detail', [
            'model' => $model
        ]);
    }
    public function actionGetdoctorsearch(){
        $list_doctor='<option value=""></option>';
        $select_district=0;
        $i=0;
        if (!empty($_GET['cat_id']))
            $list_war='';
        $find_doctor=Supporter::getDoctor($_GET['cat_id']);
        if(!empty($find_doctor)){
            foreach ($find_doctor as $dis){
                $list_doctor.='<option value="'.$dis->id.'">'.$dis->name.'</option>';
                if($i==0) $select_district=$dis->id;
                $i++;
            }
        }
        return json_encode([
            'list_doctor'=>$list_doctor,
            'select_district'=>$select_district
        ]);
    }
    public function actionGetdoctor(){
        $list_doctor='';
        $select_district=0;
        $i=0;
        if (!empty($_GET['cat_id']))
            $list_war='';
        $find_doctor=Supporter::getDoctor($_GET['cat_id']);
        if(!empty($find_doctor)){
            foreach ($find_doctor as $dis){
                $list_doctor.='<option value="'.$dis->id.'">'.$dis->name.'</option>';
                if($i==0) $select_district=$dis->id;
                $i++;
            }
        }
        return json_encode([
            'list_doctor'=>$list_doctor,
            'select_district'=>$select_district
        ]);
    }
    public function actionGeturlform1()
    {
        if (isset($_POST['cat'])) {
            $list=$_POST['cat'].'/'.$_POST['doctor'].'/'.$_POST['date'];
            $len=base64_encode($list);
            $url=Url::to(['site/book-doctor','i'=>$len]);
            return json_encode([
                'url'=>$url
            ]);
        }
        return 0;
    }
    public function actionGeturlform()
    {
        if (isset($_POST['date'])) {
            $list=$_POST['name'].'/'.$_POST['phone'].'/'.$_POST['date'];
            $len=base64_encode($list);
            $url=Url::to(['site/book-doctor','i'=>$len]);
            return json_encode([
                'url'=>$url
            ]);
        }
        return 0;
    }
    public function actionBookDoctor1($i='')
    {
        $seo = Seo::getSeo(Seo::APP_PAGE);
        $this->setBigTitle('Đặt lịch');
        if (!empty($seo)) {
            $this->setBigTitle($seo->site_title);
        }
        $model = new SubscribeForm();
        $model->scenario=SubscribeForm::SCENARIO_BOOK;
        $cat_id=0;
        $doctor_id=0;
        if(isset( $_GET['i'])){
            $chuoi= explode('/',base64_decode( $_GET['i']));
            $cat_id=$chuoi[0];
            $doctor_id=$chuoi[1];
            $date=$chuoi[2];
            $model->cat=$cat_id;
            $model->doctor=$doctor_id;
            $model->date=$date;
            $i=$_GET['i'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $subject = 'Đặt lịch khám bệnh từ website: ' . Url::base(true);
            $arrInfo = [
                Yii::t('app', 'fullname') => $model->name,
                Yii::t('app', 'phone') => $model->phone,
                'Khoa, phòng khám' => CatDoctor::findOne($model->cat)->name,
                'Bác sĩ' => Supporter::findOne($model->doctor)->name,
                'Ngày đặt' => $model->date,
                'Giờ đặt' => Partner::findOne($model->time)->name,
                Yii::t('app', 'message') => $model->body,
            ];
            $content = '<h1>Đặt lịch khám bệnh</h1>';
            foreach ($arrInfo as $key => $value) {
                $content .= '<p><strong>' . $key. ':</strong> ' . nl2br($value) . '</p>';
            }
            if (MyExt::sendMail($this->cont->email, $subject, $content)) {
                $record = new ContactCustomer();
                $record->name = $model->name;
                $record->email = $model->name;
                $record->mobile = $model->phone;
                $record->title = 'Đặt lịch khám';
                $record->content = $content;
                if ($record->validate()) {
                    $record->save();
                }
                Yii::$app->session->setFlash('contact', Yii::t('app', 'contact-msg-success'));
            } else {
                Yii::$app->session->setFlash('contact', Yii::t('app', 'contact-msg-error'));
            }
            return $this->render('pages/book', [
                'model' => $model,
            ]);
        } else {
            return $this->render('pages/book', [
                'model' => $model,
            ]);
        }
    }
    public function actionBookDoctor($i='')
    {
        $seo = Seo::getSeo(Seo::APP_PAGE);
        $this->setBigTitle('Đặt lịch');
        if (!empty($seo)) {
            $this->setBigTitle($seo->site_title);
        }
        $model = new SubscribeForm();
        $model->scenario=SubscribeForm::SCENARIO_BOOK2;
        $cat_id=0;
        $doctor_id=0;
        if(isset( $_GET['i'])){
            $chuoi= explode('/',base64_decode( $_GET['i']));
            $cat_id=$chuoi[0];
            $doctor_id=$chuoi[1];
            $date=$chuoi[2];
            $model->name=$cat_id;
            $model->phone=$doctor_id;
            $model->date=$date;
            $i=$_GET['i'];
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $subject = 'Đặt lịch khám bệnh từ website: ' . Url::base(true);
            $arrInfo = [
                Yii::t('app', 'fullname') => $model->name,
                Yii::t('app', 'phone') => $model->phone,
                'Ngày đặt' => $model->date,
                Yii::t('app', 'message') => $model->body,
            ];
            $content = '<h1>Đặt lịch khám bệnh</h1>';
            foreach ($arrInfo as $key => $value) {
                $content .= '<p><strong>' . $key. ':</strong> ' . nl2br($value) . '</p>';
            }
            if (MyExt::sendMail($this->cont->email, $subject, $content)) {
                $record = new ContactCustomer();
                $record->name = $model->name;
                $record->email = $model->name;
                $record->mobile = $model->phone;
                $record->title = 'Đặt lịch khám';
                $record->content = $content;
                if ($record->validate()) {
                    $record->save();
                }
                Yii::$app->session->setFlash('contact', Yii::t('app', 'contact-msg-success'));
            } else {
                Yii::$app->session->setFlash('contact', Yii::t('app', 'contact-msg-error'));
            }
            return $this->render('pages/book', [
                'model' => $model,
            ]);
        } else {
            return $this->render('pages/book', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Knowledge main page
     */
    public function actionKnowledge()
    {
        $this->setBigTitle('Kiến thức Y khoa', true);
        return $this->render('knowledge');
    }

    /**
     * Knowledge news page
     */
    public function actionKnowledgeNews()
    {
        $this->setBigTitle('Tin tức Y khoa', true);
        return $this->render('knowledge-news');
    }

    /**
     * Knowledge Q&A page
     */
    public function actionKnowledgeQa()
    {
        $this->setBigTitle('Hỏi đáp', true);
        return $this->render('knowledge-qa');
    }

    /**
     * Knowledge self-check page
     */
    public function actionKnowledgeSelfCheck()
    {
        $this->setBigTitle('Hướng dẫn Tự khám', true);
        return $this->render('knowledge-self-check');
    }

    /**
     * Knowledge downloads page
     */
    public function actionKnowledgeDownloads()
    {
        $this->setBigTitle('Tài liệu Tải về', true);
        return $this->render('knowledge-downloads');
    }

    /**
     * Branches main page
     */
    public function actionBranches()
    {
        $this->setBigTitle('Chi nhánh', true);
        return $this->render('branches');
    }

    /**
     * Branch detail page
     */
    public function actionBranchDetail($city = 'ha-noi')
    {
        $this->setBigTitle('Chi nhánh ' . ucfirst(str_replace('-', ' ', $city)), true);
        return $this->render('branch-detail', ['city' => $city]);
    }


    /**
     * Contact info page
     */
    public function actionContactInfo()
    {
        $this->setBigTitle('Thông tin liên hệ', true);
        return $this->render('contact-info');
    }

    /**
     * Contact question page
     */
    public function actionContactQuestion()
    {
        $this->setBigTitle('Gửi câu hỏi', true);
        return $this->render('contact-question');
    }

    /**
     * Contact recruitment page
     */
    public function actionContactRecruitment()
    {
        $this->setBigTitle('Tuyển dụng', true);
        return $this->render('contact-recruitment');
    }
}
