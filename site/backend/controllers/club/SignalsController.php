<?php

class SignalsController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';

    public function actionIndex()
    {
        $models = UserSignal::model()->findAll();
        $this->render('index', array(
            'models'=>$models
        ));
    }

    public function actionTake(){
        $signal_id = Yii::app()->request->getPost('id');
    }
}
