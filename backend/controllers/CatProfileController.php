<?php

namespace backend\controllers;

use Yii;
use backend\models\CatProfile;
use backend\models\search\CatProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;

/**
 * CatProfileController implements the CRUD actions for CatProfile model.
 */
class CatProfileController extends InitController
{
    /**
     * Lists all CatProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatProfileSearch();
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
     * Creates a new CatProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CatProfile();
        $model->active = 1;

        if (in_array(Yii::$app->request->get('position'), array_keys(CatProfile::getPosition()))) {
            $model->position = Yii::$app->request->get('position');
        }


        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload() && $model->save()) {
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CatProfile model.
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

            if ($model->upload() && $model->save()) {

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
     * Deletes an existing CatProfile model.
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
     * Finds the CatProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CatProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CatProfile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSort()
    {
        $request = Yii::$app->request;
        if (!empty($request->get('ids_str'))) {
            $menu_arr = explode(',', Yii::$app->request->get('ids_str'));
            foreach ($menu_arr as $key => $val) {
                if (is_int((int) $val)) {
                    $model = $this->findModel($val);
                    $model->ord = $key;
                    $model->update();
                }
            }

            $parent_id = (int) $request->get('parent_id');
            $item_id = (int) $request->get('item_id');
            if (is_int($parent_id)) {
                $model = $this->findModel($item_id);
                $model->parent = $parent_id;
                $model->update();
            }
        }
    }
}
