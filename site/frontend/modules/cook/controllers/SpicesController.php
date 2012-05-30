<?php

class SpicesController extends HController
{
    //public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->pageTitle = 'Приправы специи';
        $basePath = Yii::getPathOfAlias('cook') . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'spices' . DIRECTORY_SEPARATOR . 'assets';
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        //Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
        $obj = CookSpices::model()->getSpicesByAlphabet();

        $this->render('index', compact('obj'));
    }

    public function actionCategory($id)
    {
        $model = CookSpicesCategories::model()->with('spices', 'photo')->findByPk($id);
        $this->render('category', compact('model'));
    }

    public function actionView($id)
    {
        $model = CookSpices::model()->with('photo', 'categories', 'hints')->findByPk($id);
        $this->render('view', compact('model'));
    }
}