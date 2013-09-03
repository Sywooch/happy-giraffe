<?php

class DefaultController extends ServiceController
{
    /**
     * @sitemap
     */
	public function actionIndex()
	{
        $this->pageTitle = 'Как определить группу крови ребенка? Группа крови родителей';

		$this->render('index');
	}
}