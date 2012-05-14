<?php
/**
 * Author: choo
 * Date: 13.05.2012
 */
class ActivityController extends HController
{
    public function actionIndex()
    {
        Yii::import('application.widgets.activity.*');
        $this->render('index');
    }
}
