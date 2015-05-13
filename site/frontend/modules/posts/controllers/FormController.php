<?php

namespace site\frontend\modules\posts\controllers;

/**
 * Description of FormController
 *
 * @author Кирилл
 */
class FormController extends \LiteController
{

    public $litePackage = 'member';
    public $layout = '//layouts/lite/form';
    public $bodyClass = 'body__create';

    public function actionPhotopost($id = false)
    {
        $this->render('photopost', array('id' => $id));
    }

    public function actionStatus($id = false)
    {
        $this->render('status', array('id' => $id));
    }

    public function actionVideo($id = false)
    {
        $this->render('video', array('id' => $id));
    }

}
