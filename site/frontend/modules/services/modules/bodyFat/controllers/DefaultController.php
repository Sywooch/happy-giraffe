<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Калькулятор процента жира в организме';
        $this->render('index', array('model' => new BodyFatForm()));
    }


    public function actionCalculate()
    {
        if (isset($_POST['BodyFatForm'])) {
            $model = new BodyFatForm();
            $model->attributes = $_POST['BodyFatForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'body-fat-form') {
                echo $validationResult;
                Yii::app()->end();
            }

            $calcs = $model->calculate();
            $result['html'] = $this->renderPartial('_result', array('result' => $calcs), true);
            //$result['result'] = $calcs;
            //$result['input'] = $model->attributes;

            header('Content-type: application/json');
            echo CJSON::encode($result);
        }
    }
}