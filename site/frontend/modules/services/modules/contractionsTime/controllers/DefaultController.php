<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
	public function actionIndex()
	{
        $this->pageTitle = 'Схватки перед родами. Считаем схватки';

		$this->render('index');
	}
}