<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionCalculate(){
        if (Yii::app()->request->isAjaxRequest){
            if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year']) && isset($_POST['cycle'])
                && isset($_POST['critical_period'])){

            }
        }else
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }
}