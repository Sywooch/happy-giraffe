<?php

namespace site\frontend\modules\som\modules\status\controllers;

/**
 * Description of DefaultController
 *
 * @author Кирилл
 */
class DefaultController extends \LiteController
{

    public $litePackage = 'posts';

    public function actionIndex()
    {
        $this->renderText('status');
    }

}
