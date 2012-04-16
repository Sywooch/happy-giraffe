<?php

class DefaultController extends Controller
{
    public $layout = 'main';

	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionDecret()
    {
        $this->render('index');
    }
}
