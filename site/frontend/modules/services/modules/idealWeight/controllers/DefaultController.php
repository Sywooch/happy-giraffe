<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет идеального веса';
        $this->render('index', array('model' => new IdealWeightForm()));
    }


    public function actionCalculate()
    {
        if (isset($_POST['IdealWeightForm'])) {
            $model = new IdealWeightForm();
            $model->attributes = $_POST['IdealWeightForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'ideal-weight-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            //$result['html'] = $this->renderPartial('_result', array('result' => $model->calculate()), true);
            $result = $model->calculate();
            header('Content-type: application/json');
            echo CJSON::encode($result);
        }
    }
}