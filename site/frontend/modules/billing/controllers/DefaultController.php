<?php

class DefaultController extends HController
{
	//public $layout='//layouts/column2';

	public function actionIndex()
	{
		$this->render('index');
	}
}