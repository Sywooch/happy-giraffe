<?php

class DefaultController extends HController
{
    public $layout = '//layouts/lite/main';

    public function actionIndex()
    {
        $this->render('index');
    }
}