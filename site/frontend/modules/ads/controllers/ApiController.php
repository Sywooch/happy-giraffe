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
        \Yii::app()->getModule('ads')->manager->toggle($preset, $modelPk, $line, $properties);
    }


    public function actionCookie()
    {
        $widget = new \PhotopostAdWidget();
        if (! isset(\Yii::app()->request->cookies['photo-popup-1'])) {
            \Yii::app()->request->cookies['photo-popup'] = new \CHttpCookie('photo-popup-1', 1);
            $banner = $widget->getBanner();
        } else {
            $banner = null;
        }
        $this->data = $banner;
        $this->success = true;
    }

    public function actionTest()
    {
        sleep(20);
    }
}