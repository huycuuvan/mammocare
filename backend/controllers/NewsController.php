<?php
namespace backend\controllers;
use Yii;
use backend\models\News;
use backend\models\search\NewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use yii\web\UploadedFile;
use yii\helpers\Url;
/**
 * NewsController implements the CRUD actions for News model.
 */
class NewsController extends InitController
{
    /**
     * Lists all News models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewsSearch();
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
    public function actionNews()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        $arr = [];
        $model = News::find()
        ->where(['{{news}}.active' => 1, '{{language}}.code' => Yii::$app->language])
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
     * Creates a new News model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new News();
        $model->active = 1;
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->doc = UploadedFile::getInstance($model, 'doc');
            if ($model->upload() && $model->save()) {
                return $this->redirect(['index']);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    /**
     * Updates an existing News model.
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
     * Deletes an existing News model.
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
     * Finds the News model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return News the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionCopy($id)
    {
        $request = Yii::$app->request;
        if ($request->isPost) {
            $languageId = $request->post('copy-target');
            $id = intval($request->post('id'));
            $total = intval($request->post('copy-number'));
            $news = News::findOne($id);
            $success = 0;
            for ($i = 0; $i < $total; $i++) {
                $copyNews = new News();
                $copyNews->attributes = $news->attributes;
                $copyNews->lang_id = $languageId;
                $copyNews->user_id = Yii::$app->user->id;
                if ($copyNews->save()) {
                    $pid = $copyNews->id;
                    $rand = rand(10, 100) . $pid;
                    $oldImg = $news->path;
                    $oldThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . basename($oldImg);
                    $newImg = dirname($oldImg) . DIRECTORY_SEPARATOR . $rand . basename($oldImg);
                    $newThumbImg = dirname($oldImg) . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR . $rand . basename($oldImg);
                    $rootDir = realpath($_SERVER["DOCUMENT_ROOT"]) ;
                    $baseDir = $rootDir . DIRECTORY_SEPARATOR . Url::base() . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR;
                    copy($baseDir . $oldImg, $baseDir . $newImg);
                    copy($baseDir . $oldThumbImg, $baseDir . $newThumbImg);
                    $copyNews->path = $newImg;
                    $copyNews->save();
                    $success ++;
                }
            }
            if ($success > 0) {
                Yii::$app->session->setFlash('copy', sprintf('Sao chép <strong>%d</strong> tin tức thành công.', $total));
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('copy', sprintf('Sao chép <strong>%d</strong> tin tức không thành công.', $total));
                return $this->refresh();
            }
        }
        return $this->render('copy', ['id' => $id]);
    }
}
