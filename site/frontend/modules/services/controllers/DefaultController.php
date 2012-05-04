<?php

class DefaultController extends HController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}