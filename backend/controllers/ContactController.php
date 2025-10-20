<?php

namespace backend\controllers;

use Yii;
use backend\models\Contact;
use backend\models\Language;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\controllers\InitController;

/**
 * ContactController implements the CRUD actions for Contact model.
 */
class ContactController extends InitController
{

    /**
     * Lists all Contact models.
     * @return mixed
     */
     public function actionIndex()
     {
         $model = Contact::getContact();
         if (!empty($model))
             return $this->redirect(['update', 'id' => $model->id]);
         else
             return $this->redirect(['create']);
     }

    /**
     * Creates a new Contact model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = Contact::getContact();
        if (!empty($model)) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        $model = new Contact();
        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->img_footer = UploadedFile::getInstance($model, 'img_footer');
            $model->img_mobile = UploadedFile::getInstance($model, 'img_mobile');
            $model->doc = UploadedFile::getInstance($model, 'doc');

            if ($model->upload() && $model->save()) {
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Contact model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->language->code != Yii::$app->language)
            return $this->redirect(['index']);

        $tmp_logo = $model->logo; //Lưu tạm ảnh đại diện
        $tmp_footer = $model->logo_footer; //Lưu tạm ảnh đại diện
        $tmp_mobile = $model->logo_mobile; //Lưu tạm ảnh đại diện
        if ($model->load(Yii::$app->request->post())) {
            $model->img = UploadedFile::getInstance($model, 'img');
            $model->img_footer = UploadedFile::getInstance($model, 'img_footer');
            $model->img_mobile = UploadedFile::getInstance($model, 'img_mobile');
            $model->doc = UploadedFile::getInstance($model, 'doc');

            if ($model->upload() && $model->save()) {
                /*
                 * Phần này xử lý khi click vào nút xóa mục Ảnh đại diện
                 * thì xóa ảnh đi
                 */
                if (!empty($tmp_logo) && empty($model->logo)) {
                    $model->deleteImg($tmp_logo);
                }

                if (!empty($tmp_footer) && empty($model->logo_footer)) {
                    $model->deleteImg($tmp_footer);
                }

                if (!empty($tmp_mobile) && empty($model->logo_mobile)) {
                    $model->deleteImg($tmp_mobile);
                }

                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionOffice($id)
    {
        $model = $this->findModel($id);

        $data = file_get_contents("php://input");
        if (isset($data) && (is_object(json_decode($data)) || is_array(json_decode($data)))) {
            Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
            $json = json_decode($data);
            if (empty($json->status)) {
                $model->json_office = $data;
            } else {
                $ho = $json->headOffice;
                $model->head_office = $ho->name;
                $model->address = $ho->address;
                $model->phone = $ho->phone;
                $model->hotline = $ho->hotline;
                $model->email = $ho->email;
            }

            if ($model->save())
                return ['status' => true];
            else
                return ['status' => false, 'error' => 'Cập nhật không thành công!'];
        }

        return $this->render('office', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Contact model.
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
     * Finds the Contact model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contact the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contact::findOne($id)) !== null) {
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

          $contactSource = Contact::getContactByLang($sourceId);
          $contactTarget = Contact::getContactByLang($targetId);

          if (empty($contactTarget))
            $contactTarget = new Contact();

          $attr = $contactSource->attributes;
          unset($attr['logo']);
          unset($attr['logo_footer']);
          unset($attr['logo_mobile']);
          unset($attr['lang_id']);
          unset($attr['id']);

          foreach ($attr as $key => $value) {
            $contactTarget->$key = $value;
          }
          $contactTarget->lang_id = $targetId;
          $contactTarget->save();

          $arrLang = Language::getLanguageDDL();

          Yii::$app->session->setFlash('copy', 'Sao chép ngôn ngữ thành công: <strong>' . $arrLang[$sourceId] . '</strong> -> <strong>' . $arrLang[$targetId] . '</strong>');
          return $this->refresh();
        }

        return $this->render('copy');
    }
}
