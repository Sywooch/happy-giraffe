<?php
namespace site\frontend\modules\posts\modules\myGiraffe\components\behaviors;
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
//        \Yii::app()->gearman->client()->doBackground('myGiraffeHandle', serialize(array(
//            'postId' => $this->owner->id,
//        )));
    }
}