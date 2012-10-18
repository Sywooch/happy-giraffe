<?php

class DefaultController extends SController
{
	public function actionIndex()
	{
        $parser = new MailRuUserParser;
        //for($i=50;$i<90;$i++){
            $parser->user = MailruUser::model()->findByPk(6);
            $parser->parsePage();
//        }
	}
}