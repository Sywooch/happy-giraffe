<?php

class DefaultController extends BController
{
    public $layout = '//layouts/club';

	public function actionIndex()
	{
		$this->render('index');
	}
}