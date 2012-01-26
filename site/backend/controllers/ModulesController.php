<?php

class ModulesController extends BController
{
    public $layout = 'club';

    public function actionIndex()
    {
        $this->render('index');
    }
}