<?php
namespace site\frontend\modules\analytics\controllers;
use site\frontend\modules\analytics\components\VisitsManager;

/**
 * @author Никита
 * @date 26/01/15
 */

class DefaultController extends \HController
{
    public function actionTest()
    {
        $vm = new VisitsManager();
        $vm->inc();
    }
} 