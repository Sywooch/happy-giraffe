<?php

class DefaultController extends HController
{

    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет суточной потребности калорий';

        $this->render('index', array('model' => new DailyCaloriesForm()));
    }


    public function actionCalculate()
    {
        if (isset($_POST['DailyCaloriesForm'])) {
            $model = new DailyCaloriesForm();
            $model->attributes = $_POST['DailyCaloriesForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'calories-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            $result['html'] = $this->renderPartial('_result', array('result' => $model->calculate()), true);
            header('Content-type: application/json');
            echo CJSON::encode($result);
        }
    }
}