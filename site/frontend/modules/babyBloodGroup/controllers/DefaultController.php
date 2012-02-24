<?php

class DefaultController extends Controller
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