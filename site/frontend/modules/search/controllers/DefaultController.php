<?php

class DefaultController extends HController
{
	public function actionIndex($query)
	{
        $results = SearchManager::search($query, null, null, 1);
        $this->render('index', $results);
	}
}