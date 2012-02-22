<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
	public function actionIndex()
	{
		$this->render('index');
	}
}