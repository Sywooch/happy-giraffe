<?php

class WallpapersController extends Controller
{

    public $layout = '//layouts/new';

    public function actionIndex()
    {
        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'wallpapers' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->user->setState('wallpapersCalcAreas', array());
        $this->pageTitle = 'Расчет обоев';
        $this->render('index', array('model' => new WallpapersCalcForm(), 'emptyArea' => new WallpapersAreaForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['WallpapersCalcForm'])) {
            $model = new WallpapersCalcForm;
            $model->attributes = $_POST['WallpapersCalcForm'];
            $this->performAjaxValidation($model);
            $model->validate();
            //$this->renderPartial('result', array('result' => $model->calculate()));
            echo CJSON::encode($model->calculate());
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
            $model->validate();
            $areas = Yii::app()->user->getState('wallpapersCalcAreas');
            $areas[] = array('title' => $model->title, 'height' => $model->height, 'width' => $model->width);
            Yii::app()->user->setState('wallpapersCalcAreas', $areas);
            $this->renderPartial('emptyarea', array('areas' => $areas));
        }
    }

    public function actionRemovearea($id)
    {
        $areas = Yii::app()->user->getState('wallpapersCalcAreas');
        if (isset($areas[$id]))
            unset($areas[$id]);
        Yii::app()->user->setState('wallpapersCalcAreas', $areas);
        $this->renderPartial('emptyarea', array('areas' => $areas));
    }
}