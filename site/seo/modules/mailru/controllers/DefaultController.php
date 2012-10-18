<?php

class DefaultController extends SController
{
	public function actionIndex()
	{
        $parser = new MailRuUserParser;
        $parser->user = MailruUser::model()->findByPk(6);
        $parser->parsePage();
	}
}