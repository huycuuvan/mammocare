<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\Contact;
use backend\models\SendMail;
use backend\models\password\PasswordResetRequestForm;
use backend\models\password\ResetPasswordForm;
use yii\helpers\Url;
use backend\models\Language;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'request-password-reset', 'reset-password', 'change-lang'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'change-lang', 'grab-img', 'get-chart'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $session = Yii::$app->session;
        if (!$session->has('language')) {
            $lang = Language::find()
            ->where(['active' => 1])
            ->orderBy(['defa' => SORT_DESC])
            ->one();
            if (!empty($lang)) {
                $session->set('language', $lang->code);
            }
        }
        Yii::$app->language = $session->get('language');

        if (!$session->isActive) {
            $session->open();
        }
        if (!empty($session->get('user_roles'))) {
            $task_arr = unserialize($session->get('user_roles'));
            $this->view->params['task_allowed'] = $task_arr;
        } else {
            Yii::$app->user->logout();
        }
        $session->close();

        return true;
    }

    public function actionChangeLang($code)
    {
        $session = Yii::$app->session;
        $session->set('language', $code);
        Yii::$app->language = $session->get('language');

        if (Yii::$app->request->referrer) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            return $this->redirect(Yii::$app->homeUrl);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('site/login');
        }
//
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        $this->layout = 'log';
        $cont = Contact::getContact();

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
                'cont' => $cont
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        $session = Yii::$app->session;
        if (!$session->isActive) {
            $session->open();
        }
        $session->remove('user_roles');
        $session->remove('roles_list');
        $session->close();

        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'log';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Vui lòng kiểm tra email của bạn để thay đổi lại mật khẩu.');

            //return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
             'model' => $model,
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
        $this->layout = 'log';
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Mật khẩu mới đã được cập nhật thành công.<br/>Tới trang <a href="'.Url::to(['site/login']).'">Đăng Nhập</a>');

            //return $this->goHome();
        }

        return $this->render('resetPassword', [
             'model' => $model,
         ]);
    }

    /**
     * Dùng xác thực tài khoản khi đăng ký tài khoản mới
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Dùng gửi lại email xác thực tài khoản khi đăng ký tài khoản mới
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
             'model' => $model
         ]);
    }

    public function actionGrabImg()
    {
        $content = Yii::$app->request->post('text');

        $regexp = '<img[^>]+src="([^">]+)"';

        $totalGrab = 0;
        
        $domain = $_SERVER['SERVER_NAME'];
        
        if (preg_match_all("/$regexp/i", $content, $matches, PREG_SET_ORDER)) {
            if (!empty($matches)) {

                for ($i = 0; $i < count($matches); $i++) {
                    $img_src = $matches[$i][1];

                    //Check $img_src start with http or https and not in host
                    if (strpos($img_src, 'http') === 0 && strpos($img_src, $domain) === false) {
                        $filename = basename($img_src);
                        //Download file from url save with curl
                        $ch = curl_init($img_src);
                        $fp = fopen(Yii::getAlias('@webroot/../upload/cdn/images/'.$filename), 'wb');
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_exec($ch);
                        curl_close($ch);
                        fclose($fp);

                        $content = \str_ireplace($img_src, Yii::$app->params['basePath'] . '/upload/cdn/images/' . $filename, $content);
                        $totalGrab++;
                    }
                }
            }
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->asJson([
            'totalImg' => $totalGrab,
            'content' => $content
        ]);
    }

    public function actionGetChart()
    {
        $request = Yii::$app->request;
        
        //Yii create command
        $command = Yii::$app->db->createCommand("SELECT count(cookie_mark) as visitor, count(distinct cookie_mark) as uniquevisitor, date(created_at) as day FROM `hit_counter` WHERE created_at between :startdate AND :enddate group by date(created_at) ORDER BY date(created_at)  asc")
        ->bindValue(':startdate', $request->post('startDate') . ' 00:00:00')
        ->bindValue(':enddate', $request->post('endDate') . ' 23:59:59');

        //Execute query
        $result = $command->queryAll();
        $data= [];

        foreach ($result as $key => $value) {
            $data[] = [
                'day' => date('d/m/Y', strtotime($value['day'])),
                'visitor' => $value['visitor'],
                'uniquevisitor' => $value['uniquevisitor']
            ];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->asJson($data);
    }
}
