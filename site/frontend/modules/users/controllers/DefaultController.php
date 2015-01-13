<?php
/**
 * @author Никита
 * @date 13/01/15
 */

namespace site\frontend\modules\users\controllers;


class DefaultController extends \LiteController
{
    public $layout = '//lite/common';
    public $litePackage = 'member';

    public function actionSettings()
    {
        $this->render('settings');
    }
} 