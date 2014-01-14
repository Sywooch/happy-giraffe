<?php

class DefaultController extends HController
{
	public function actionTest()
	{
        $check = AntispamCheck::model()->findAll();
        foreach ($check as $c)
            echo $c->relatedModel->title;

		$this->render('index');
	}
}