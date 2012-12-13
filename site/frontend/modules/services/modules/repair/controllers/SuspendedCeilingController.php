<?php

class SuspendedCeilingController extends HController
{

    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет материалов для подвесного потолка';
        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'suspendedCeiling' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        $this->render('index', array('SuspendedCeilingModel' => new SuspendedCeilingForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['SuspendedCeilingForm'])) {
            $service = Service::model()->findByPk(16);
            $service->userUsedService();

            $model = new SuspendedCeilingForm();
            $model->attributes = $_POST['SuspendedCeilingForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'SuspendedCeiling-calculate-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            $this->renderPartial('result', array('result' => $model->calculate()));
        }
    }

}