<?php

namespace backend\controllers;

use Yii;
use backend\models\Menu;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends InitController
{

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Menu::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();
        $model->active = 1;

        if (in_array(Yii::$app->request->get('position'), array_keys(Menu::getPosition()))) {
            $model->position = Yii::$app->request->get('position');
        } else {
            return $this->redirect(['index']);
        }


        if ($model->load(Yii::$app->request->post())) {
            if ($model->type != '0:0')
                $model->link = Menu::getPath($model->type);

            $model->img = UploadedFile::getInstance($model, 'img');
            if ($model->uploadback() && $model->save())
                return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->type != '0:0')
                $model->link = Menu::getPath($model->type);

            $model->img = UploadedFile::getInstance($model, 'img');
            if ($model->uploadback() && $model->save())
                return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
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
            if (empty($model->getSubAdmin())) {
                $model->delete();
                return ["status" => true];
            } else {
                return [
                    "status" => false,
                    "message" => "Không thể xóa vì danh mục này có các danh mục con!"
                ];
            }
        }

        return ["status" => false];
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
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
