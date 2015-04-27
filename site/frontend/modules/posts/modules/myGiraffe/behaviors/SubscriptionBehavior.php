<?php
/**
 * @todo Делает много лишней работы (сколько подписок меняется, столько раз перестраивается лента, придумать как оптимизировать
 * @author Никита
 * @date 27/04/15
 */

namespace site\frontend\modules\posts\modules\myGiraffe\behaviors;


use site\frontend\modules\posts\modules\myGiraffe\components\FeedManager;

class SubscriptionBehavior extends \CActiveRecordBehavior
{
    public function afterSave()
    {
        \Yii::app()->gearman->client()->doBackground('myGiraffeUpdateUser', $this->owner->user_id);
    }

    public function afterDelete()
    {
        \Yii::app()->gearman->client()->doBackground('myGiraffeUpdateUser', $this->owner->user_id);
    }
}