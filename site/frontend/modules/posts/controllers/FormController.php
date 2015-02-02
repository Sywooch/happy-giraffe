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
    public $layout = '/layouts/newBlogPost';

    public function actionPhotopost()
    {
        $this->render('photopost');
    }

    public function actionStatus()
    {
        $this->render('status');
    }

}
