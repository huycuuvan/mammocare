<?php

namespace backend\controllers;

use Yii;
use backend\models\Tab;
use backend\models\Language;
use backend\models\search\TabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * TabController implements the CRUD actions for Tab model.
 */
class TabController extends InitController
{

    /**
     * Lists all Tab models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TabSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        $find=Tab::find()->all();
//        if(!empty($find))
//            foreach ($find as $row){
//                if($row->lang_id==1){
//                    $new=new Tab();
//                    $new->name=$row->name;
//                    $new->code=$row->code;
////                $new->path=$row->path;
//                    $new->type=$row->type;
//                    $new->lang_id=2;
//                    $new->save();
//                }
//
//            }
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
     * Creates a new Tab model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tab();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->upload() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tab model.
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

            if ($model->upload() && $model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tab model.
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
     * Finds the Tab model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tab the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tab::findOne($id)) !== null) {
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

          $tabsSource = Tab::getTabsByLang($sourceId);

          foreach ($tabsSource as $row) {
            $model = Tab::getTabByKeyLang($row->code, $targetId);


            if (empty($model)) {
              $model = new Tab();
              $model->code = $row->code;
              $model->name = $row->name;
              $model->type = $row->type;

              $model->ord = $row->ord;
              $model->lang_id = $targetId;

              if($row->type == 2) {
                //Copy image
                $rand = rand(10,100);
                $oldImg = $row->path;
                $oldThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . basename($oldImg);
                $newImg = dirname($oldImg) . DIRECTORY_SEPARATOR . $rand . basename($oldImg);
                $newThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $rand . basename($oldImg);

                $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]) ;
                $baseDir = $rootDir . DIRECTORY_SEPARATOR . Url::base() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;

                copy( $baseDir . $oldImg, $baseDir . $newImg);
                copy( $baseDir . $oldThumbImg, $baseDir . $newThumbImg);

                $model->path = $newImg;
              }

              $model->save();
            }
          }

          $arrLang = Language::getLanguageDDL();

          Yii::$app->session->setFlash('copy', 'Sao chép ngôn ngữ thành công: <strong>' . $arrLang[$sourceId] . '</strong> -> <strong>' . $arrLang[$targetId] . '</strong>');
          return $this->refresh();
        }

        return $this->render('copy');
    }
}
