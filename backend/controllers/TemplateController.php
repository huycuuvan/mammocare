<?php

namespace backend\controllers;

use Yii;
use backend\models\Template;
use backend\models\search\TemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;

/**
 * TemplateController implements the CRUD actions for Template model.
 */
class TemplateController extends InitController
{

    /**
     * Lists all Template models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TemplateSearch();
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

    public function actionTemplate()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $arr = [];
        $model = Template::find()
        ->where(['{{template}}.active' => 1, '{{language}}.code' => Yii::$app->language])
        ->joinWith(['language'])
        ->orderBy(['id' => SORT_DESC])
        ->all();
        if (isset($model)) {
            foreach ($model as $row) {
                $arr[] = ["id" => $row->id, "path" => Yii::$app->urlManagerFrontend->baseUrl.'/'.$row->path, "title" => $row->title, "cat_id" => $row->cat_id];
            }
        }
        return $arr;
    }

    /**
     * Creates a new Template model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Template();
        $model->active = 1;
        $model->user_id = Yii::$app->user->id;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->doc = UploadedFile::getInstance($model, 'doc');
            $model->img = UploadedFile::getInstance($model, 'img');
            if ($model->upload() && $model->uploadback() &&  $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Template model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $tmp_path = $model->path; //Lưu tạm ảnh đại diện
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->doc = UploadedFile::getInstance($model, 'doc');
            $model->img = UploadedFile::getInstance($model, 'img');

            if ($model->upload() && $model->uploadback() && $model->save()) {
                
                /*
                 * Phần này xử lý khi click vào nút xóa mục Ảnh đại diện
                 * deleteImg function được thừa kế từ models/HasImgTrait.php
                 */
                if (!empty($tmp_path) && empty($model->path)) {
                    $model->deleteImg($tmp_path);
                }

                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Template model.
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
     * Finds the Template model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Template the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Template::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
