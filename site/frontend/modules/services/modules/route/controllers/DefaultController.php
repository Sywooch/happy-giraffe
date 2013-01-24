<?php

class DefaultController extends HController
{
	public function actionIndex()
	{
        //CRouteLinking::model()->add(16586);
	}

    public function actionTest()
    {
        $this->render('index');
    }

    public function actionMap(){
        $this->render('map');
    }
}