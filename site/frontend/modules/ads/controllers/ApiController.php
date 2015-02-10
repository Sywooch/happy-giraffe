<?php
namespace site\frontend\modules\ads\controllers;
use site\frontend\modules\ads\components\CreativeInfoProvider;
use site\frontend\modules\ads\components\DfpHelper;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 04/02/15
 */

class ApiController extends \site\frontend\components\api\ApiController
{
    public function actionToggle($preset, $modelPk, $line, array $properties = array())
    {
        $creative = \Yii::app()->getModule('ads')->creativesFactory->create($preset, $modelPk, $properties);
        \Yii::app()->getModule('ads')->manager->toggle($creative, $line);
    }
}