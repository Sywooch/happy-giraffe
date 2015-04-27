<?php
namespace site\frontend\modules\posts\modules\myGiraffe\behaviors;
use site\frontend\modules\posts\modules\myGiraffe\components\FeedManager;

/**
 * @author Никита
 * @date 17/04/15
 */

class PostBehavior extends \CActiveRecordBehavior
{
    public function afterSave()
    {
        FeedManager::handle($this->owner);
    }
}