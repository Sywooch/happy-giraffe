<?php
/**
 * Виджет для вставки в layout, подгружает все составляющие виджеты модуля
 */

class LayoutWidget extends CWidget
{
    public function run()
    {
        if(!Yii::app()->clientScript->useAMD)
            Yii::app()->clientScript->registerPackage('ko_registerWidget');
        $this->render('LayoutWidget');
    }
}