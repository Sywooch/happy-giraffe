<?php
namespace site\frontend\modules\analytics\controllers;
use site\frontend\modules\analytics\components\DfpHelper;

/**
 * @author Никита
 * @date 04/02/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionTest()
    {
        $dfp = new DfpHelper();
        $dfp->addCreative();
    }
}