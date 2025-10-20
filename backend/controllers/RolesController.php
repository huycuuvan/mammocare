<?php

namespace backend\controllers;

use Yii;
use backend\models\Roles;
use backend\models\search\RolesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;

/**
 * RolesController implements the CRUD actions for Roles model.
 */
class RolesController extends InitController
{

    /**
     * Lists all Roles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RolesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*
         * $array_ids mảng id được chọn và submit
         * Xóa tất cả các bản ghi có id trong bảng $array_ids
         */
        $array_ids = Yii::$app->request->post("selection");
        if (isset($array_ids) && is_array($array_ids)) {
            $this->deleteMulti(get_parent_class($searchModel), $array_ids);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Roles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     public function actionCreate()
     {
         $model = new Roles();
         $model->active = 1;

         if ($model->load(Yii::$app->request->post())) {

             /* Chuyển mảng vai trò thành chuỗi */
             if (!empty($model->roles_list) && is_array($model->roles_list)) {
                 $model->roles_list = implode(',', $model->roles_list);
             }

             /* Chuyển mảng quyền thành chuỗi */
             if (!empty($_POST['task_ids'])) {
                 $model->task_ids = implode(',', $_POST['task_ids']);
                 $model->task_str = $model->getTaskStr();
             }

             if ($model->save()) {
                 return $this->redirect(['index']);
             }
         }

         return $this->render('create', [
             'model' => $model,
         ]);
     }

    /**
     * Updates an existing Roles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
     public function actionUpdate($id)
     {
         $model = $this->findModel($id);
         $model->roles_list = explode(',', $model->roles_list);
         $model->task_ids = explode(',', $model->task_ids);

         if ($model->load(Yii::$app->request->post())) {

             /* Chuyển mảng vai trò thành chuỗi */
             if (!empty($model->roles_list) && is_array($model->roles_list)) {
                 $model->roles_list = implode(',', $model->roles_list);
             }

             /* Chuyển mảng quyền thành chuỗi */
             if (!empty($_POST['task_ids'])) {
                 $model->task_ids = implode(',', $_POST['task_ids']);
                 $model->task_str = $model->getTaskStr();
             }

             if ($model->save()) {
                 return $this->redirect(['index']);
             }
         }

         return $this->render('update', [
             'model' => $model,
         ]);
     }

    /**
     * Deletes an existing Roles model.
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
     * Finds the Roles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Roles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Roles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
