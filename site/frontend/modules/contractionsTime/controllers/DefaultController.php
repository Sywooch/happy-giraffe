<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

	public function actionIndex()
	{
		$this->render('index');
	}
}