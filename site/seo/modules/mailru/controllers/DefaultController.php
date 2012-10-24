<?php

class DefaultController extends SController
{
	public function actionIndex()
	{
//        $parser = new MailRuUserParser;
//        $parser->start();
	}

    public function actionUsers(){
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.frontend.extensions.*');
        Yii::import('site.frontend.components.*');
        Yii::import('site.frontend.helpers.*');
        Yii::import('site.common.models.mongo.*');
        Yii::import('site.seo.models.*');

        //Yii::app()->mc->updateMailruUsers();
    }
}