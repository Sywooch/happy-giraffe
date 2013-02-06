<?php

class DefaultController extends HController
{
    protected function beforeAction($action)
    {
        Yii::app()->clientScript->registerCssFile('/stylesheets/valentine-day.css');
        return true;
    }

	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionSms(){
        $criteria = new CDbCriteria;
        $pages = new CPagination(ValentineSms::model()->count());
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $models = ValentineSms::model()->findAll($criteria);

        $this->render('sms', compact('models', 'pages'));
    }
}