<?php

class DefaultController extends ServiceController
{
    const SERVICE_ID = 10;

    public function actionIndex()
    {
        $this->pageTitle = 'Когда уходить в декрет?';
        $basePath = Yii::getPathOfAlias('maternityLeave') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        $this->render('index');
    }
}