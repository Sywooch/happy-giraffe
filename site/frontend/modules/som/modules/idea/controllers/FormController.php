<?php

namespace site\frontend\modules\som\modules\idea\controllers;

class FormController extends \LiteController
{

    public $litePackage = 'member';
    public $layout = '//layouts/lite/form';
    public $bodyClass = 'body__create';

    public function actionCreate($id = false)
    {
        $this->render('create', array('id' => $id));
    }

}