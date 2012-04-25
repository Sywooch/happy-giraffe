<?php

class FlooringController extends Controller
{

    public function actionIndex()
    {
        $this->pageTitle = 'Расчет напольного покрытия';

        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'flooring' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', 'all');

        $this->render('index', array('FlooringModel' => new FlooringForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['FlooringForm'])) {
            $model = new FlooringForm();
            $model->attributes = $_POST['FlooringForm'];
            $validationResult = CActiveForm::validate($model);
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'flooring-calculate-form') {
                echo $validationResult;
                Yii::app()->end();
            }
            $this->renderPartial('result', array('result' => $model->calculate()));
        }
    }
}