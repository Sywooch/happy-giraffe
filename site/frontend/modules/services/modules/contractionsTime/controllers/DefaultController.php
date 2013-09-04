<?php

class DefaultController extends ServiceController
{
    const SERVICE_ID = 7;

    /**
     * @sitemap
     */
	public function actionIndex()
	{
        $this->pageTitle = 'Схватки перед родами. Считаем схватки';

		$this->render('index');
	}
}