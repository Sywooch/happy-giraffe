<?php

class DefaultController extends SController
{
	public function actionIndex()
	{
        $parser = new MailRuParser;
        $parser->start();
	}

    public function actionCollect(){
        MailRuParser::collectPages();
    }
}