<?php

namespace backend\controllers;

use Yii;
use backend\models\Partner;
use backend\models\search\PartnerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;
use yii\helpers\Url;
use backend\models\Language;

/**
 * PartnerController implements the CRUD actions for Partner model.
 */
class PartnerController extends InitController
{

    /**
     * Lists all Partner models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PartnerSearch();
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
     * Creates a new Partner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Partner();
        $model->active = 1;

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->doc = UploadedFile::getInstance($model, 'doc');

            if ($model->upload() && $model->uploadback()  && $model->uploadvideo() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Partner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
//            var_dump(1231231312);
//            var_dump($model->file);
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->doc = UploadedFile::getInstance($model, 'doc');

            if ($model->upload()  && $model->uploadback() && $model->uploadvideo() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Partner model.
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
     * Finds the Partner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Partner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Partner::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCopy()
    {
        $request = Yii::$app->request;

        if ($request->isPost) {
          $sourceId = $request->post('copy-source');
          $targetId = $request->post('copy-target');

          if ($sourceId == $targetId) {
            Yii::$app->session->setFlash('copy', 'Ngôn ngữ nguồn giống với ngôn ngữ đích.');
            return $this->refresh();
          }

          $tabsSource = Partner::getPartnerByLang($sourceId);

          foreach ($tabsSource as $row) {

            $model = new Partner();
            $model->name = $row->name;
            $model->content = $row->content;
            $model->url = $row->url;
            $model->position = $row->position;
            $model->active = $row->active;
            $model->background = $row->background;
            
            $model->ord = $row->ord;
            $model->lang_id = $targetId;

            //Copy image
            $rand = rand(10,100);
            $oldImg = $row->path;

            if (!empty($oldImg)) {
                $oldThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . basename($oldImg);
                $newImg = dirname($oldImg) . DIRECTORY_SEPARATOR . $rand . basename($oldImg);
                $newThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $rand . basename($oldImg);
    
                $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]) ;
                $baseDir = $rootDir . DIRECTORY_SEPARATOR . Url::base() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
                if (\file_exists($baseDir . $oldImg))
                copy( $baseDir . $oldImg, $baseDir . $newImg);
                
                if (\file_exists($baseDir . $oldThumbImg))
                    copy( $baseDir . $oldThumbImg, $baseDir . $newThumbImg);

                $model->path = $newImg;
            } else {
                $model->path = '';
            }
 
            $model->save();
          }

          $arrLang = Language::getLanguageDDL();

          Yii::$app->session->setFlash('copy', 'Sao chép ngôn ngữ thành công: <strong>' . $arrLang[$sourceId] . '</strong> -> <strong>' . $arrLang[$targetId] . '</strong>');
          return $this->refresh();
        }

        return $this->render('copy');
    }
}
