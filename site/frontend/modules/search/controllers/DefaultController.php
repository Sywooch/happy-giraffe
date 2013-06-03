<?php

class DefaultController extends HController
{
	public function actionIndex($query, $len)
	{
        $results = SearchManager::search($query, $len);
        extract($results);
        $this->render('index', compact('total'));
	}
}