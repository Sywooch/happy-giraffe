<?php

class SpicesController extends HController
{
    //public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->pageTitle = 'Приправы специи';
        $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'calorisator' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        //Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);


        $this->render('index', array());
    }

    public function actionCategory($id)
    {
        $category = CookSpicesCategories::model()->findByPk((int)$id);
        $this->render('category', array('category' => $category));
    }

    public function actionView($id)
    {
        $spice = CookSpices::model()->findByPk((int)$id);
        $this->render('view', array('spice' => $spice));
    }


}