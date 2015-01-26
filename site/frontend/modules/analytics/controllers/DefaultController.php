<?php
namespace site\frontend\modules\analytics\controllers;

/**
 * @author Никита
 * @date 26/01/15
 */

class DefaultController extends \HController
{
    public function actionTest()
    {
        var_dump($this->module->piwik->getVisits('http://purple.dev.happy-giraffe.ru/gavno/'));
    }
} 