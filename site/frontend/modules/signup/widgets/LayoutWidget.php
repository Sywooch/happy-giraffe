<?php
/**
 * Виджет для вставки в layout, подгружает все составляющие виджеты модуля
 */

class LayoutWidget extends CWidget
{
    public function run()
    {
        Yii::app()->clientScript->registerPackage('ko_registerWidget');
        Yii::app()->clientScript->registerScriptFile('new/javascript/common.js');
        Yii::app()->clientScript->registerScriptFile('javascripts/base64.js');
        $this->render('LayoutWidget');
    }
}