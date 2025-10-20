<?php

namespace backend\controllers;

use Yii;
use backend\models\Cat;
use backend\models\search\CatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;

/**
 * CatController implements the CRUD actions for Cat model.
 */
class CatController extends InitController
{

    /**
     * Lists all Cat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CatSearch();
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
     * Creates a new Cat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cat();
        $model->active = 1;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file2 = UploadedFile::getInstance($model, 'file2');

            if ($model->upload() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $tmp_path = $model->path; //Lưu tạm ảnh đại diện
        $tmp_path2 = $model->path2; //Lưu tạm ảnh đại diện
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file2 = UploadedFile::getInstance($model, 'file2');

            if ($model->upload() && $model->save()) {

                /*
                 * Phần này xử lý khi click vào nút xóa mục Ảnh đại diện
                 * deleteImg function được thừa kế từ models/HasImgTrait.php
                 */
                if (!empty($tmp_path) && empty($model->path)) {
                    $model->deleteImg($tmp_path);
                }

                if (!empty($tmp_path2) && empty($model->path2)) {
                    $model->deleteImg($tmp_path2);
                }


                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Cat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $request = Yii::$app->request;
        if ($request->isPost) {
            $model = $this->findModel($id);
            if (empty($model->getSubCat())) {
                $model->delete();
                return ["status" => true];
            } else {
                return [
                    "status" => false,
                    "message" => "Không thể xóa vì danh mục này có các danh mục con!"
                ];
            }
        }
        

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cat::findOne($id)) !== null) {
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
                    echo $key.'-'.$val;
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
