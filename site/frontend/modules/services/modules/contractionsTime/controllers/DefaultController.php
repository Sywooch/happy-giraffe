<?php

class DefaultController extends ServiceController
{
    public $service_id = 7;

    /**
     * @sitemap
     */
	public function actionIndex()
	{
        $this->pageTitle = 'Схватки перед родами. Считаем схватки';

		$this->render('index');
	}
}