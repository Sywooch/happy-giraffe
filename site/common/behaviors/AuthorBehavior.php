<?php

namespace site\common\behaviors;

class AuthorBehavior extends \CActiveRecordBehavior
{
    public $attr = 'author_id';

    public function beforeValidate($event)
    {

        if (! $this->owner->hasAttribute($this->attr)) {
            throw new \CException('Attribute is invalid');
        }

        if ($this->owner->{$this->attr} === null) {
            if (\Yii::app()->user->isGuest) {
                throw new \CException('User must be authenticated');
            }
            $this->owner->{$this->attr} = \Yii::app()->user->id;
        }
    }

    public function beforeDelete($event)
    {
        if (\Yii::app()->user->id != $this->owner->{$this->attr}) {
            $event->isValid = false;
        }
    }
} 