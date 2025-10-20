<?php

namespace backend\controllers;

use Yii;
use backend\models\Configure;
use backend\models\CreateXml;
use backend\models\UpdateCss;
use backend\models\UpdateJs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\controllers\InitController;

/**
 * ConfigureController implements the CRUD actions for Configure model.
 */
class ConfigureController extends InitController
{

    /**
     * Lists all Configure models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = Configure::find()->one();

        if (!empty($model))
            return $this->redirect(['update', 'id' => $model->id]);
        else
            return $this->redirect(['create']);
    }

    public function actionSitemap()
    {
        $xml = new CreateXml;
        $xml->reset();

        return $this->redirect(['index']);
    }

    public function actionUpdateCss()
    {
        $model = new UpdateCss();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['update-css']);
            }
        }

        return $this->render('update_css', [
            'model' => $model,
        ]);
    }

    public function actionUpdateJs()
    {
        $model = new UpdateJs();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['update-js']);
            }
        }

        return $this->render('update_js', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Configure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Configure();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload() && $model->save()) {
                $model->updateRobots();
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Configure model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $tmp_favicon = $model->favicon; //Lưu tạm ảnh đại diện
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload() && $model->save()) {
                $model->updateRobots();
                /*
                 * Phần này xử lý khi click vào nút xóa mục Ảnh đại diện
                 * thì xóa ảnh đi
                 */
                if (!empty($tmp_favicon) && empty($model->favicon)) {
                    $model->deleteImg($tmp_favicon);
                }

                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Configure model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();
    //
    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the Configure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Configure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Configure::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
