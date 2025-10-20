<?php

namespace backend\controllers;
use backend\models\Attachment;
use backend\models\Language;
use backend\models\Product;
use backend\models\Configure;
use Yii;
use backend\models\TempProduct;
use backend\models\search\TempProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\MyExt;
use backend\components\UploadHandler;
use backend\controllers\InitController;
use yii\helpers\Url;

/**
 * TempProductController implements the CRUD actions for TempProduct model.
 */
class TempProductController extends InitController
{


    public function actionUpload()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $conf = Configure::getConfigure();

        $folder = 'upload/attachment/';
        if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
            mkdir(Yii::getAlias('@root').'/'.$folder);
        }
        if(!is_dir(Yii::getAlias('@root').'/'.$folder.'thumb/')) {
            mkdir(Yii::getAlias('@root').'/'.$folder.'thumb/');
        }

        $upload_handler = new UploadHandler([
            'upload_dir' => Yii::getAlias('@root').'/'.$folder,
            'upload_url' => $folder,
            'max_width' => $conf->max_width,
            'max_height' => $conf->max_height,
            /*
             * Phần này có thể bỏ nhưng thư mục thumb/ sẽ mặc định là thumbnail/
             */
            'image_versions' => [
                '' => ['auto_orient' => true],
                'thumbnail' => [
                    'upload_dir' => Yii::getAlias('@root').'/'.$folder.'thumb/',
                    'upload_url' => $folder.'thumb/',
                    'max_width' => $conf->product_thumb_width,
                    'max_height' => $conf->product_thumb_height
                ]
            ]
        ]);

        $response = $upload_handler->get_response();
        if (!empty($response["files"])) {
            $data = $response["files"];

            $check_default = false;
            for ($i=0; $i < count($data); $i++) {
                $row = $data[$i];

                //insert image into attachment table after setting id to file
                $model = new TempProduct();
                $model->path = $row->thumbnailUrl;

                $model->insert();

                //setup url of thumbnail again to display images at homepage
                $data[$i]->url = $row->thumbnailUrl;
                $data[$i]->thumbnailUrl = Yii::$app->urlManagerFrontend->baseUrl ."/". $row->thumbnailUrl;
            }
            $response["files"] = $data;
        }


        return $this->redirect(['index']);
    }

    /**
     * Lists all TempProduct models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TempProductSearch();
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
     * Displays a single TempProduct model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new TempProduct model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TempProduct();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TempProduct model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TempProduct model.
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

    public function actionAdd(){
        $request = Yii::$app->request;

        if(isset($_POST)){
            if(!empty($_POST['selection'])){
//                var_dump($_POST['selection']);
                foreach ($_POST['selection'] as $item){
                    $model = TempProduct::findOne(['id'=>(int)$item]);
                    if($model->name && $model->cat_id){
                        $product = new Product();
                        $product->name = $model->name;
                        $product->category_id = $model->cat_id;
                        $product->sale = $model->price > 0?$model->price:0;
                        $product->path = $model->path;
                        $product->active = 1;
                        $product->user_id = Yii::$app->user->id;
                        $product->brief = $request->post('product-brief');
                        $product->description = $request->post('product-desc');
                        $product->home = 0;
                        $product->hot = 0;
                        $product->best = 0;

                        $product->lang_id = Language::findOne(['code'=>Yii::$app->language])->id;
                        if($product->save(false)){
                            $attachment = new Attachment();
                            $attachment->path = $model->path;
                            $attachment->pid = $product->id;
                            $attachment->ord = 1;
                            $attachment->save();
                            if ($_POST['check_add_delete'] == 1) {
                                $model->delete();
//                                var_dump($item);
                            }

                        }
                        else{
                            var_dump($product->save(false)); die;
                        }
                    }
                }
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the TempProduct model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TempProduct the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TempProduct::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
