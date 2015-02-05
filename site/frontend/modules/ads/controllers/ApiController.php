<?php
namespace site\frontend\modules\ads\controllers;
use site\frontend\modules\ads\components\DfpHelper;

/**
 * @author Никита
 * @date 04/02/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionTest()
    {
        $dfp = new DfpHelper();
        $this->data = $dfp->addCreative();
    }
}