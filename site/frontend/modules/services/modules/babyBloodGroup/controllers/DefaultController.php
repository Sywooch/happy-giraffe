<?php

class DefaultController extends HController
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
	public function actionIndex()
	{
        $this->pageTitle = 'Как определить группу крови ребенка? Группа крови родителей';

		$this->render('index');
	}
}