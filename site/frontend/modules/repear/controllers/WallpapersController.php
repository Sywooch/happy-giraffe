<?php
session_start();
class WallpapersController extends Controller
{
    public function actionIndex()
    {
        $basePath = Yii::getPathOfAlias('repear') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'wallpapers' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', 'all');

        if (isset($_SESSION['wallpapersCalc']['emptyAreas']))
            unset($_SESSION['wallpapersCalc']['emptyAreas']);
        $this->pageTitle = 'Расчет обоев';
        $this->render('index', array('model' => new WallpapersCalcForm(), 'emptyArea' => new WallpapersAreaForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['WallpapersCalcForm'])) {
            $model = new WallpapersCalcForm;
            $model->attributes = $_POST['WallpapersCalcForm'];
            $this->performAjaxValidation($model);

            $result['perimeter'] = ($model->room_length + $model->room_width) * 2;

            $this->renderPartial('result', array(
                'calcResult' => $result,
                'model' => $model
            ));
        }
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'wallpapers-calculate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddemptyarea()
    {
        if (isset($_POST['WallpapersAreaForm'])) {
            $model = new WallpapersAreaForm();
            $model->attributes = $_POST['WallpapersAreaForm'];
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'empty-area-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $_SESSION['wallpapersCalc']['emptyAreas'][] = $_POST['WallpapersAreaForm'];
            $this->renderPartial('emptyarea', array(
                'model' => $model
            ));
        }
    }
}