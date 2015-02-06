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
    public function actionTest()
    {
        $post = Content::model()->byEntity('CommunityContent', 52301)->find();
        $info = new CreativeInfoProvider('bigPost', $post);
        $this->module->manager->toggle($post, 'bigPost', 'bigPost');

    }
}