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
        /*$basePath = Yii::getPathOfAlias('repair') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'suspendedCeiling' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        $this->render('index', array('SuspendedCeilingModel' => new SuspendedCeilingForm()));*/

        $this->render('index', array('DailyCaloriesForm' => new DailyCaloriesForm()));
    }
}