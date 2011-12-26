<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new2';

	public function actionIndex()
	{
		$this->render('index');
	}
}