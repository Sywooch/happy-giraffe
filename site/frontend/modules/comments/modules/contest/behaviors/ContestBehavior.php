<?php
namespace site\frontend\modules\comments\modules\contest\behaviors;

/**
 * @author Никита
 * @date 20/02/15
 */

class ContestBehavior extends \CActiveRecordBehavior
{
    private $_textBackup;

    public function beforeValidate()
    {
        $this->_textBackup = $this->owner->text;
    }

    public function afterSave()
    {
        if ($this->owner->isNewRecord) {
            die('123');
            \Yii::app()->gearman->client()->doBackground('commentAdded', serialize(array($this->owner->id)));
        } else {
            \Yii::app()->gearman->client()->doBackground('commentUpdated', serialize(array($this->owner->id, $this->_textBackup)));
        }
    }

    public function afterDelete()
    {
        \Yii::app()->gearman->client()->doBackground('commentRemoved', serialize(array($this->owner->id)));
    }
}