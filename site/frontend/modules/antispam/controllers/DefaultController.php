<?php

class DefaultController extends HController
{
	public function actionTest()
	{
        $check = AntispamCheck::model()->with('relatedModel')->findAll();
        foreach ($check as $c)
            echo $c->relatedModel->title;

		$this->render('index');
	}
}