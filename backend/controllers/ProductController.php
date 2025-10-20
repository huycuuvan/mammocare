<?php

namespace backend\controllers;

use Yii;
use backend\models\Product;
use backend\models\search\ProductSearch;
use backend\models\Attachment;
use backend\models\CatProduct;
use backend\models\PropertyPrice;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use backend\models\PropertyProduct;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\helpers\Url;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends InitController
{

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*
         * $array_ids mảng id được chọn và submit
         * Xóa tất cả các bản ghi có id trong bảng $array_ids
         */
        $array_ids = Yii::$app->request->post("selection");
        if (isset($array_ids) && is_array($array_ids)) {
            $this->deleteMulti(get_parent_class($searchModel), $array_ids, true);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->active = 1;
        //        $model->status = 1;
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                if (!empty($model->pid))
                    Attachment::updateAll(['pid' => $model->id], 'pid = ' . $model->pid . ' OR pid NOT IN (SELECT DISTINCT id FROM product)');

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        $model->brand_id = !empty($model->brand_id) ? explode(',', $model->brand_id) : 0;
//        if (empty($model->status))
//            $model->status = 2;

        if ($model->load(Yii::$app->request->post())) {
           
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveNew() // Function này đang được sử dụng, id sản phẩm được lấy từ field PID
    {
        // Kiểm tra xem sản phẩm đã tồn tại hay chưa bằng pid gửi từ form
        $request = Yii::$app->request->post();
        if (!Product::find()->where(["id" => $request['Product']['pid']])->exists()) { // Nếu chưa tồn tại thì tạo mới
            $model = new Product();
            $model->active = 1;
            $model->status = 1;
            $model->user_id = Yii::$app->user->id;
        } else {
            $model = $this->findModel($request['Product']['pid']); // Rồi thì update
            if (empty($model->status))
                $model->status = 2;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!empty($model->pid))
                Attachment::updateAll(['pid' => $model->id], 'pid = ' . $model->pid . ' OR pid NOT IN (SELECT DISTINCT id FROM product)');

            $propery_list = $model->getPropertyJson();
            $img_list = Attachment::getImgDDLByProduct($model->id);

            // Lưu và gửi ajax về 1 mảng json để hiển thị thuộc tính vả ảnh
            $arr = [
                'property_list' => $propery_list,
                'model_id' => $model->id,
                'img' => $img_list,
                'price' => $model->sale,
                "status" => 1,
            ];

            return json_encode($arr);
        } else {
            $error = ActiveForm::validate($model);
            Yii::$app->response->format = trim(Response::FORMAT_JSON);
            return $error;
        }
    }

    public function actionUpdateImageValue()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $msg = '';
        $status = false;

        $request = Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $property_product_id = $request->post('property_product_id');
            $attachment_id = $request->post('attachment_id');

            $model = PropertyProduct::findOne($property_product_id);
            $model->attachment_id = $attachment_id;
            $model->save();
        }
    }

    public function actionUpdatePropertyPrice()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $property_product_id = $request->post('property_product_id');
            $property_price = $request->post('property_price');

            $model = PropertyProduct::findOne($property_product_id);
            $model->property_price = $property_price;
            $model->save();
        }
    }

    public function actionUpdatePropertyActive()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $property_product_id = $request->post('property_product_id');
            $active_value = $request->post('active');

            $model = PropertyProduct::findOne($property_product_id);
            $model->active = $active_value;
            $model->save();
        }
    }


    public function actionCopy($id)
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
            $languageId = $request->post('copy-target');
            $id = intval($request->post('id'));
            $total = intval($request->post('copy-number'));

            $product = Product::findOne($id);

            $success = 0;

            for ($i = 0; $i < $total; $i++) {
                $copyProduct = new Product();
                $copyProduct->attributes = $product->attributes;
                $copyProduct->lang_id = $languageId;

                if ($copyProduct->save()) {
                    $pid = $copyProduct->id;
                    
                    $imgs = $product->imgs;

                    $attMap = [];
                    
                    foreach ($imgs as $img) {
                        //Copy image
                        $rand = rand(10, 100) . $pid;
                        $oldImg = str_replace('/thumb', '', $img->path);
                        $oldThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . basename($oldImg);
                        $newImg = dirname($oldImg) . DIRECTORY_SEPARATOR . $rand . basename($oldImg);
                        $newThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $rand . basename($oldImg);

                        $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]) ;
                        $baseDir = $rootDir . DIRECTORY_SEPARATOR . Url::base() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

                        copy($baseDir . $oldImg, $baseDir . $newImg);
                        copy($baseDir . $oldThumbImg, $baseDir . $newThumbImg);

                        if ($img->ord == 1) {
                            $copyProduct->path = $newThumbImg;
                            $copyProduct->save();
                        }

                        $attachment = new Attachment();
                        $attachment->path = $newThumbImg;
                        $attachment->ord = $img->ord;
                        $attachment->pid = $pid;
                        $attachment->save();

                        $attMap[$img->id] = $attachment->id;
                    }

                    $properties = $product->properties;

                    foreach ($properties as $property) {
                        $propertyProduct = new PropertyProduct();
                        $propertyProduct->property_id = $property->property_id;
                        $propertyProduct->product_id = $pid;
                        $propertyProduct->property_value_id = $property->property_value_id;
                        $propertyProduct->attachment_id = isset($attMap[$property->attachment_id]) ? $attMap[$property->attachment_id] : '';
                        $propertyProduct->property_price = $property->property_price;
                        $propertyProduct->active = $property->active;
                        $propertyProduct->save();
                    }

                    $cats = $product->catProduct;
                    foreach ($cats as $cat) {
                        $productCat = new CatProduct();
                        $productCat->product_id = $pid;
                        $productCat->cat_id = $cat->cat_id;
                        $productCat->save();
                    }

                    $success ++;
                }
            }

            if ($success > 0) {
                Yii::$app->session->setFlash('copy', sprintf('Sao chép <strong>%d</strong> sản phẩm thành công.', $total));
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('copy', sprintf('Sao chép <strong>%d</strong> sản phẩm không thành công.', $total));
                return $this->refresh();
            }
        }

        return $this->render('copy', ['id' => $id]);
    }
    public function actionSavePrice() // Function này đang được sử dụng, id sản phẩm được lấy từ field PID
    {
        // Kiểm tra xem sản phẩm đã tồn tại hay chưa bằng pid gửi từ form
//        $request = Yii::$app->request->post();
        return $this->renderPartial('list',['product_id'=>$_GET['id'],'property_list'=>$_GET['property']]);
    }
    public function actionSavePriceProperty(){
        if(isset($_GET['product']) && isset($_GET['value']) && isset($_GET['price'])){
            $find=PropertyPrice::find()->where(['product_id'=>$_GET['product'],'property_string'=>$_GET['value']])->one();
            if(!empty($find)){
                $find->price=$_GET['price'];
                $find->save(false);
            }
            else{
                $new= new  PropertyPrice();
                $new->price=$_GET['price'];
                $new->product_id=$_GET['product'];
                $new->property_string=$_GET['value'];
                $new->save(false);
            }
            return 1;
        }
    }
}
