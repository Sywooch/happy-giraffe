<?php

class ModulesController extends BController
{
    public $layout = 'club';
    public $section = 'club';

    public function actionIndex()
    {
        $this->render('index');
    }
}