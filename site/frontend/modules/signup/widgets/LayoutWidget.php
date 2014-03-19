<?php
/**
 * Виджет для вставки в layout, подгружает все составляющие виджеты модуля
 */

class LayoutWidget extends CWidget
{
    public function run()
    {
        $this->render('LayoutWidget');
    }
}