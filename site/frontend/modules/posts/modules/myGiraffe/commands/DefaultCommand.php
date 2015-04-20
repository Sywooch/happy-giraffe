<?php
namespace site\frontend\modules\posts\modules\myGiraffe\commands;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\modules\myGiraffe\components\FeedManager;

/**
 * @author Никита
 * @date 17/04/15
 */

class DefaultCommand extends \CConsoleCommand
{
    public function actionTest()
    {
        $post = Content::model()->byEntity('CommunityContent', 52306)->find();
        FeedManager::handle($post);
    }
}