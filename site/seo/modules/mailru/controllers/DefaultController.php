<?php

class DefaultController extends SController
{
	public function actionIndex()
	{
        $parser = new MailRuForumThemeParser;
        $parser->start();
	}
}