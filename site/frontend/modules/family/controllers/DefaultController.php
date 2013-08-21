<?php

class DefaultController extends HController
{
	public function actionSignup()
	{
        $json = Yii::app()->user->model->getFamilyData();
        $this->layout = '//layouts/simple';
        $this->render('signup', compact('json'));
	}
}