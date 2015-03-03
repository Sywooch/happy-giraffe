<?php
namespace site\frontend\modules\comments\modules\contest\behaviors;
use site\frontend\modules\comments\modules\contest\components\CommentsHandler;

/**
 * @author Никита
 * @date 20/02/15
 */

class ContestBehavior extends \CActiveRecordBehavior
{
    public function events()
    {
        return array_merge(parent::events(), array(
            'onAfterSoftDelete' => 'afterSoftDelete',
            'onAfterSoftRestore' => 'afterSoftRestore',
        ));
    }

    public function afterSave()
    {
        if ($this->owner->isNewRecord) {
            \Yii::app()->gearman->client()->doBackground('handleComment', serialize(array(
                'commentId' => $this->owner->id,
                'event' => CommentsHandler::EVENT_ADD,
            )));
        } else {
            \Yii::app()->gearman->client()->doBackground('handleComment', serialize(array(
                'commentId' => $this->owner->id,
                'event' => CommentsHandler::EVENT_UPDATE,
            )));
        }
    }

    public function afterSoftDelete()
    {
        \Yii::app()->gearman->client()->doBackground('handleComment', serialize(array(
            'commentId' => $this->owner->id,
            'event' => CommentsHandler::EVENT_REMOVE,
        )));
    }

    public function afterSoftRestore()
    {
        \Yii::app()->gearman->client()->doBackground('handleComment', serialize(array(
            'commentId' => $this->owner->id,
            'event' => CommentsHandler::EVENT_RESTORE,
        )));
    }
}