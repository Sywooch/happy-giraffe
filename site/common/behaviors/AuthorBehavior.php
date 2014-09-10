<?php

namespace site\common\behaviors;

class AuthorBehavior extends \CActiveRecordBehavior
{
    public $attr = 'author_id';

    protected function beforeValidate($event)
    {
        if (parent::beforeValidate($event)) {
            if ($this->author_id === null) {
                if (! $this->owner->hasProperty($this->attr)) {
                    throw new \CException('Attribute is invalid');
                }
                if (! \Yii::app()->user->isGuest) {
                    throw new \CException('User must be authenticated');
                }
                $this->author_id = \Yii::app()->user->id;
            }
            return true;
        }
        return false;
    }
} 