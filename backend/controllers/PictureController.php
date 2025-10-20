<?php

namespace backend\controllers;

use Yii;
use backend\models\Picture;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\MyExt;
use backend\components\UploadHandler;
use backend\controllers\InitController;
use yii\helpers\Url;

/**
 * PictureController implements the CRUD actions for Picture model.
 */
class PictureController extends InitController
{

    /**
     * Lists all Picture models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Picture::find(),
        ]);

        /*
         * $array_ids mảng id được chọn và submit
         * Xóa tất cả các bản ghi có id trong bảng $array_ids
         */
        $array_ids = Yii::$app->request->post("selection");
        if (isset($array_ids) && is_array($array_ids)) {
            $this->deleteMulti('backend\models\Picture', $array_ids, true);
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionUpload()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $folder = 'upload/picture/';
        if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
            mkdir(Yii::getAlias('@root').'/'.$folder);
        }
        if(!is_dir(Yii::getAlias('@root').'/'.$folder.'thumb/')) {
            mkdir(Yii::getAlias('@root').'/'.$folder.'thumb/');
        }

        $upload_handler = new UploadHandler([
            'upload_dir' => Yii::getAlias('@root').'/'.$folder,
            'upload_url' => $folder,
            /*
             * Phần này có thể bỏ nhưng thư mục thumb/ sẽ mặc định là thumbnail/
             */
            'image_versions' => [
                '' => ['auto_orient' => true],
                'thumbnail' => [
                    'upload_dir' => Yii::getAlias('@root').'/'.$folder.'thumb/',
                    'upload_url' => $folder.'thumb/',
                    'max_width' => 600,
                    'max_height' => 600
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
                $model = new Picture();
                $model->path = $row->thumbnailUrl;
                $model->album_id = $row->pid;
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
    public function actionUpload1()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $folder = 'upload/picture/';
        if(!is_dir(Yii::getAlias('@root').'/'.$folder)) {
            mkdir(Yii::getAlias('@root').'/'.$folder);
        }
        if(!is_dir(Yii::getAlias('@root').'/'.$folder.'thumb/')) {
            mkdir(Yii::getAlias('@root').'/'.$folder.'thumb/');
        }

        $upload_handler = new UploadHandler([
            'upload_dir' => Yii::getAlias('@root').'/'.$folder,
            'upload_url' => $folder,
            /*
             * Phần này có thể bỏ nhưng thư mục thumb/ sẽ mặc định là thumbnail/
             */
            'image_versions' => [
                '' => ['auto_orient' => true],
                'thumbnail' => [
                    'upload_dir' => Yii::getAlias('@root').'/'.$folder.'thumb/',
                    'upload_url' => $folder.'thumb/',
                    'max_width' => 600,
                    'max_height' => 600
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
                $model = new Picture();
                $model->path = $row->thumbnailUrl;
                $model->album_id = $row->pid;
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
     * Creates a new Picture model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Picture();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Picture model.
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

    public function actionChangeOrder()
    {
        $json = json_decode(file_get_contents("php://input"));
        foreach ($json as $val) {
            $model = $this->findModel($val->ele_id);
            $model->ord = $val->ele_ord;
            $model->save();
        }
    }

    public function actionUpdateAlt()
    {
        $json = json_decode(file_get_contents("php://input"));
        $model = $this->findModel($json->pic_id);
        $model->alt = $json->pic_alt;
        $model->save();
    }

    /**
     * Deletes an existing Picture model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionDelete($id)
     {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $model = $this->findModel($id);
        if (isset($model->path)) {
            $img_path = Yii::getAlias('@frontend')."/web/".$model->path;
            $bimg_path = str_replace('thumbnail/', '', $img_path);

            if (file_exists($bimg_path)) {
                unlink($bimg_path);
            }

            if (file_exists($img_path)) {
                unlink($img_path);
            }
        }
        return $model->delete();
     }

    /**
     * Finds the Picture model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Picture the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Picture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionReturnyoutube()
    {
        if(isset($_POST['id'])){
            $record = Picture::find()->where('id='.$_POST['id'])->one();
            $data=$record->code;
            return json_encode($data,true);
        }
        else
            return '';

    }
    public function actionSaveyoutube()
    {
        if(isset($_POST['id']) && isset($_POST['value'])){
            $record = Picture::findOne($_POST['id']);
            $record->code = $_POST['value'];
            $record->save(false);
            return 1;
        }
        else
            return 0;

    }
}
