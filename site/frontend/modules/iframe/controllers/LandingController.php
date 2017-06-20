<?php

class LandingController extends HController
{
    public function actionIndex()
    {
        Yii::app()->clientScript->reset();
        $this->layout = false;
        $this->render('online-chat');
    }
}