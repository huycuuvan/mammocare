<?php

namespace backend\controllers;

use Yii;
use backend\models\District;
use backend\models\Province;
use backend\models\search\DistrictSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\controllers\InitController;
use backend\models\ImportForm;
use backend\components\MyExt;
use yii\web\UploadedFile;

/**
 * DistrictController implements the CRUD actions for District model.
 */
class DistrictController extends InitController
{
    
    /**
     * Lists all District models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DistrictSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single District model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new District model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new District();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing District model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing District model.
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
     * Finds the District model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return District the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = District::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionImport()
    {
        $model=new ImportForm();
        if($model->load(Yii::$app->request->post()))
        {
            {
                $model->file  = UploadedFile::getInstance($model,'file');
                $file_name = 'upload/' .rand(3, 9999). MyExt::removeSign($model->file->baseName).'.'.$model->file->extension;
                $model->file->saveAs(Yii::getAlias('@root').'/'.$file_name, false);
                $filename= Yii::getAlias('@root').'/'.$file_name;
                require_once(Yii::getAlias('@vendor/phpoffice/phpexcel/vendor/PHPExcel.php'));
                $objPHPExcel = new \PHPExcel();
                $inputFileType = \PHPExcel_IOFactory::identify($filename);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileType);
                $objReader->setReadDataOnly(true);
                /**  Load $inputFileName to a PHPExcel Object  **/
                $objPHPExcel = $objReader->load("$filename");
                $total_sheets=$objPHPExcel->getSheetCount();
                $allSheetName=$objPHPExcel->getSheetNames();
                $objWorksheet  = $objPHPExcel->setActiveSheetIndex(0);
                $highestRow    = $objWorksheet->getHighestRow();
                $highestColumn = $objWorksheet->getHighestColumn();
                $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                $arraydata = array();
                for ($row = 2; $row <= $highestRow;++$row)
                {
                    for ($col = 0; $col <$highestColumnIndex;++$col)
                    {
                        $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                        $arraydata[$row-2][$col]=$value;
                    }
                }
                if(!empty($arraydata)){
                    foreach ($arraydata as $row){
                        if($row[0]!=''){
                            $find=Province::find()->where('code ="'.trim($row[1]).'"')->one();
                            $find_district=District::find()->where('code = "'.trim($row[3]).'" and province_id='.$find->id)->one();
                            if(empty($find_district)){
                                $data = new District();
                                $data->name=$row[2];
                                $data->code=$row[3];
                                $data->province_id=$find->id;
                                $data->save(false);
                            }
                        }

                    }
                    if(file_exists($filename))
                        unlink($filename);
                    $this->redirect(array('index'));
                }
            }


        }
        return $this->render('import',array(
            'model'=>$model,
        ));
    }
}
