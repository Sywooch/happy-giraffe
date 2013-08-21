<?php

class DefaultController extends HController
{
    public $layout = 'subscribes';

	public function actionIndex()
	{
        Yii::import('site.frontend.modules.profile.widgets.*');
		$this->render('index');
	}
}