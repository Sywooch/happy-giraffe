<?php

class PaintController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Расчет объема краски';

        $basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'paint' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

        Yii::app()->user->setState('emptyAreas', array());

        $this->render('index', array('model' => new PaintForm(), 'emptyArea' => new PaintAreaForm()));
    }

    public function actionCalculate()
    {
        if (isset($_POST['PaintForm'])) {
            $service = Service::model()->findByPk(14);
            $service->userUsedService();

            $model = new PaintForm();
            $model->attributes = $_POST['PaintForm'];
            $this->performAjaxValidation($model);
            $model->validate();
            echo CJSON::encode($model->calculate());
        }
    }

    public function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == 'paint-calculate-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAddemptyarea()
    {
        if (isset($_POST['PaintAreaForm'])) {
            $model = new PaintAreaForm();
            $model->attributes = $_POST['PaintAreaForm'];
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'empty-area-form') {
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }
            $model->validate();
            $areas = Yii::app()->user->getState('emptyAreas');
            $areas[] = array('title' => $model->title, 'height' => $model->height, 'width' => $model->width, 'qty' => $model->qty);
            Yii::app()->user->setState('emptyAreas', $areas);
            $this->renderPartial('emptyarea', array('areas' => $areas));
        }
    }

    public function actionRemovearea($id)
    {
        $areas = Yii::app()->user->getState('emptyAreas');
        if (isset($areas[$id]))
            unset($areas[$id]);
        Yii::app()->user->setState('emptyAreas', $areas);
        $this->renderPartial('emptyarea', array('areas' => $areas));
    }
}