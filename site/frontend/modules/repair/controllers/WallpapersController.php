<?php

class WallpapersController extends Controller
{
    public function actionIndex()
    {
        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'wallpapers' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($baseUrl . '/style.css', 'all');
        $session = new CHttpSession;
        $session->open();
        if (isset($session['wallpapersCalcAreas']))
            unset($session['wallpapersCalcAreas']);
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
            $this->renderPartial('result', array('result' => $model->calculate()));
        }
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'wallpapers-calculate-form') {
            echo $model->validate();
            Yii::app()->end();
        }
    }

    public function actionAddemptyarea()
    {
        if (isset($_POST['WallpapersAreaForm'])) {
            $model = new WallpapersAreaForm();
            $model->attributes = $_POST['WallpapersAreaForm'];
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'empty-area-form') {
                echo $model->validate();
                Yii::app()->end();
            }
            $model->validate();
            $session = new CHttpSession;
            $session->open();
            $areas = $session['wallpapersCalcAreas'];
            $areas[] = array('title' => $model->title, 'height' => $model->height, 'width' => $model->width);
            $session['wallpapersCalcAreas'] = $areas;
            $this->renderPartial('emptyarea', array('areas' => $areas));
        }
    }

    public
    function actionRemovearea($id)
    {
        $session = new CHttpSession;
        $session->open();
        $areas = $session['wallpapersCalcAreas'];
        if (isset($areas[$id]))
            unset($areas[$id]);
        $session['wallpapersCalcAreas'] = $areas;
        $this->renderPartial('emptyarea', array('areas' => $areas));
    }
}