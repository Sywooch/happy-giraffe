<?php

Yii::import('zii.behaviors.CTimestampBehavior');

/**
 * Расширенное поведение для работы с датой создания и датой обновления
 *
 * @author Кирилл
 */
class HTimestampBehavior extends CTimestampBehavior
{

    public $publicationAttribute = null;
    public $owerwriteAttributeIfSet = true;

    public function getUnixTimeByAttribute($attribute, $milliseconds = false)
    {
        $ts = strpos($this->owner->getTableSchema()->getColumn($attribute)->dbType, 'int') === 0 ? $this->owner->$attribute : strtotime($this->owner->$attribute);
        return $ts * ($milliseconds ? 1000 : 1);
    }

    public function getPubUnixTime($milliseconds = false)
    {
        return $this->getUnixTimeByAttribute($this->publicationAttribute ? : $this->createAttribute, false);
    }

    public function getPubDate($format = 'Y-m-d\TH:i:sP')
    {
        return date($format, $this->pubUnixTime);
    }

    /**
     * Responds to {@link CModel::onBeforeSave} event.
     * Sets the values of the creation or modified attributes as configured
     *
     * @param CModelEvent $event event parameter
     */
    public function beforeSave($event)
    {
        if ($this->getOwner()->getIsNewRecord() && ($this->createAttribute !== null))
        {
            if ($this->owerwriteAttributeIfSet || empty($this->owner->{$this->createAttribute}))
                $this->owner->{$this->createAttribute} = $this->getTimestampByAttribute($this->createAttribute);
        }
        if ((!$this->getOwner()->getIsNewRecord() || $this->setUpdateOnCreate) && ($this->updateAttribute !== null))
        {
            $this->owner->{$this->updateAttribute} = $this->getTimestampByAttribute($this->updateAttribute);
        }
    }

}