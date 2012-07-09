<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет похудения';
        $this->render('index', array('model' => new WeightLossForm(), 'dailyModel' => new DailyCaloriesForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['WeightLossForm'])) {
            $model = new WeightLossForm();
            $model->attributes = $_POST['WeightLossForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'weight-loss-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            $result['html'] = $this->renderPartial('_result', array('result' => $model->calculate()), true);
            $result['result'] = $model->calculate();
            //$result = $model->calculate();
            header('Content-type: application/json');
            echo CJSON::encode($result);
        }
    }
}