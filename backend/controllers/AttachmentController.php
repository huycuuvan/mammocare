<?php

namespace backend\controllers;

use Yii;
use backend\models\Attachment;
use backend\models\search\AttachmentSearch;
use backend\models\Product;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\MyExt;
use backend\components\UploadHandler;
use backend\controllers\InitController;
use yii\helpers\Url;
use backend\models\Configure;

/**
 * AttachmentController implements the CRUD actions for Attachment model.
 */
class AttachmentController extends InitController
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
                $model = new Attachment();
                $model->path = $row->thumbnailUrl;

                $model->pid = $row->pid;
                $model->code = '';
                if ($model->insert())
                    $data[$i]->id = $model->id;

                //setup url of thumbnail again to display images at homepage
                $data[$i]->url = $row->thumbnailUrl;
                $data[$i]->thumbnailUrl = Yii::$app->urlManagerFrontend->baseUrl ."/". $row->thumbnailUrl;
            }
            $response["files"] = $data;
        }

        return $response;
    }

    /**
     * Lists all Attachment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttachmentSearch();
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
     * Updates an existing Attachment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        if (!empty($_POST["ids_str"])) {
            $arr_ids = explode(",", $_POST["ids_str"]);
            $i=1;
            foreach ($arr_ids as $key) {
                $model = Attachment::findOne($key);
                $model->ord = $i;
                $model->save();
                if ($i==1 && !empty($model->pid)) {
                    $pmodel = Product::findOne($model->pid);
                    if (!empty($pmodel)) {
                        $pmodel->path = $model->path;
                        $pmodel->save();
                    }

                    //$path = $pmodel->getErrors();
                }

                $i++;
            }

            return ["status" => true];
        }

        return ["status" => false];
    }

    /**
     * Deletes an existing Attachment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionDelete($id)
     {
         Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
         $model = $this->findModel($id);

         if ($model->delete()) {
             return ["status" => true];
         } else {
             return ["status" => false];
         }
     }

    /**
     * Finds the Attachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Attachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attachment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSaveyoutube()
    {
        if(isset($_POST['id']) && isset($_POST['value'])){
            $record = Attachment::findOne($_POST['id']);
            $record->code = $_POST['value'];
            $record->save(false);
            return 1;
        }
        else
            return 0;

    }
    public function actionReturnyoutube()
    {
        if(isset($_POST['id'])){
            $record = Attachment::find()->where('id='.$_POST['id'])->one();
            $data=$record->code;
            return json_encode($data,true);
        }
        else
            return '';

    }
}
