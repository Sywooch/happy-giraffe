<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionRemoveAll()
    {
        if (Yii::app()->user->checkAccess('administrator')){
            ScoreInput::model()->deleteAll();
            ScoreOutput::model()->deleteAll();
            ScoreVisits::model()->deleteAll();
        }
    }
}