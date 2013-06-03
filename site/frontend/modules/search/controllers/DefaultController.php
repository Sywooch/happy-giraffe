<?php

class DefaultController extends HController
{
	public function actionIndex($query)
	{
        $results = SearchManager::search($query);
        extract($results);
        //$this->render('index', compact('total'));
	}
}