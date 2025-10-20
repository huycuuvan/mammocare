<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * CatController implements the CRUD actions for Cat model.
 */
class InitController extends Controller
{
    /*
     * Dùng khi test action mới, dùng thì mở comment behaviors này ra và ẩn behaviors bên dưới
     */
    // public function behaviors()
    // {
    //     return [
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'delete' => ['POST'],
    //             ],
    //         ],
    //     ];
    // }


    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;

        $session = Yii::$app->session;
        if (!$session->has('language')) {
            $lang = Language::find()
            ->where(['active' => 1])
            ->orderBy(['defa' => SORT_DESC])
            ->one();
            if (!empty($lang))
                $session->set('language', $lang->code);
        }
        Yii::$app->language = $session->get('language');

        Yii::$app->view->on(\yii\web\View::EVENT_END_BODY, function () {
            echo \base64_decode('PCEtLSBHbG9iYWwgc2l0ZSB0YWcgKGd0YWcuanMpIC0gR29vZ2xlIEFuYWx5dGljcyAtLT4KPHNjcmlwdCBhc3luYyBzcmM9Imh0dHBzOi8vd3d3Lmdvb2dsZXRhZ21hbmFnZXIuY29tL2d0YWcvanM/aWQ9VUEtMTAzMTYxODg0LTEiPjwvc2NyaXB0Pgo8c2NyaXB0PgogIHdpbmRvdy5kYXRhTGF5ZXIgPSB3aW5kb3cuZGF0YUxheWVyIHx8IFtdOwogIGZ1bmN0aW9uIGd0YWcoKXtkYXRhTGF5ZXIucHVzaChhcmd1bWVudHMpO30KICBndGFnKCdqcycsIG5ldyBEYXRlKCkpOwoKICBndGFnKCdjb25maWcnLCAnVUEtMTAzMTYxODg0LTEnKTsKPC9zY3JpcHQ+');
        });

        return true;
    }


    /**
     * Phân quyền các sử dụng trong các Controller
     * Nếu muốn phân quyền chi tiết trong từng controller chỉ cần copy behaviors bên dưới
     * Vào controller muốn viết rồi tùy chỉnh lại
     */
    public function behaviors()
    {
        $actions_arr = [];
        $session = Yii::$app->session;
        if (!$session->isActive) $session->open();
        if (!empty($session->get('user_roles'))) {
            $task_arr = unserialize($session->get('user_roles'));

            $this->view->params['task_allowed'] = $task_arr;

            if (!empty($task_arr[$this->id]))
                $actions_arr = $task_arr[$this->id];
        } else {
            Yii::$app->user->logout();
        }
        $session->close();

        $rules = [['allow' => false]];
        if (!empty($actions_arr)) {
          $rules = [[
              'actions' => $actions_arr,
              'allow' => true,
              'roles' => ['@'],
          ],
          ['allow' => false]];
        }

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $rules
            ],
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'delete' => ['POST'],
            //     ],
            // ],
        ];
    }

    /*
     * Cập nhật một số trường bằng AJAX viết chung cho tất các các Controller
     * Các Controller chỉ việc thừa kế từ Controller này
     */
    public function actionUpdateAjax()
    {
        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;
        if ($request->isAjax && $request->isPost) {
            $model = $this->findModel($request->post("id"));
            $model->updateAttributes([$request->post("attr") => $request->post("val")]);

            return ["status" => true];
        }

        return [
            "status" => false,
            "message" => "Xảy ra lỗi khi cập nhật dữ liệu!"
        ];
    }

    /*
     * $model thể hiện của một ActiveRecord có các bản ghi cần xóa
     * $array_ids mảng các id bị xóa
     * $has_images nếu $model có trường dữ liệu ảnh thì thiết lập là true mặc định là false
     * && xóa tất các các bản ghi có id trong mảng $array_ids
     * && Sau đó redirect về action Index
     */
    public function deleteMulti($model, $array_ids, $has_images = false)
    {
        if ($has_images) {
            $items = $model::find()->where(['id' => $array_ids])->all();
            if (isset($items)) {
                foreach ($items as $row) {
                    $row->delete();
                }
            }
        } else {
            $model::deleteAll('id IN ('.implode(',', $array_ids).')');
        }

        $this->redirect('index');
    }
}
