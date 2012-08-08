<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Дата родов';
        $this->render('index', array('model' => new BirthDateForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['BirthDateForm'])) {
            $model = new BirthDateForm();
            $model->attributes = $_POST['BirthDateForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'birth-date-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            $result['html'] = $this->renderPartial('_result', array('result' => $model->calculate()), true);
            $result['result'] = $model->calculate();
            header('Content-type: application/json');
            echo CJSON::encode($result);
        }
    }
}