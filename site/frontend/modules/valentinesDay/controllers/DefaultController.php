<?php

class DefaultController extends HController
{
	public function actionIndex()
	{
        Yii::app()->clientScript->registerCssFile('/stylesheets/valentine-day.css');
		$this->render('index');
	}

    public function actionSms(){
        $models = ValentineSms::model()->findAll();

        $this->render('sms', compact('models'));
    }
}