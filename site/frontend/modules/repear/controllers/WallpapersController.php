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

            $model->normalizeLengths();
            $perimeter = ($model->room_length + $model->room_width) * 2;
            $lines = ceil($perimeter / $model->wp_width);
            if ($model->repeat) {
                $tiles = (ceil($model->room_height / $model->repeat)) * $lines;

                if (count($_SESSION['wallpapersCalc']['emptyAreas'])) {
                    foreach ($_SESSION['wallpapersCalc']['emptyAreas'] as $area) {
                        $tiles -= (floor($area['width'] / $model->wp_width) * floor($area['height'] / $model->repeat));
                    }
                }

                $result['rolls'] = ceil($tiles / (floor($model->wp_length / $model->repeat)));

            } else {
                $length = $lines * ($model->room_height + 0.1);

                if (count($_SESSION['wallpapersCalc']['emptyAreas'])) {
                    foreach ($_SESSION['wallpapersCalc']['emptyAreas'] as $area) {
                        $length -= (floor($area['width'] / $model->wp_width) * $area['height']);
                    }
                }
                $result['rolls'] = ceil($length / $model->wp_length);
            }

            $this->renderPartial('result', array('calcResult' => $result));
        }
    }

    public
    function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'wallpapers-calculate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public
    function actionAddemptyarea()
    {
        if (isset($_POST['WallpapersAreaForm'])) {
            $model = new WallpapersAreaForm();
            $model->attributes = $_POST['WallpapersAreaForm'];
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'empty-area-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $model->normalizeLength('height', array());
            $model->normalizeLength('width', array());
            $_SESSION['wallpapersCalc']['emptyAreas'][] = array('title' => $model->title, 'height' => $model->height, 'width' => $model->width);
            $this->renderPartial('emptyarea');
        }
    }

    public
    function actionRemovearea($id)
    {
        if (isset($_SESSION['wallpapersCalc']['emptyAreas'][$id]))
            unset($_SESSION['wallpapersCalc']['emptyAreas'][$id]);
        $this->renderPartial('emptyarea');
    }
}