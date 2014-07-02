<?php

namespace site\frontend\modules\notifications\behaviors;

/**
 * Поведение для модели Notification, реализующую логику работы с Comet-сервером.
 *
 * @property-read \CometModel $comet
 * @property-read \site\frontend\modules\notifications\models\Notification $owner
 * @author Кирилл
 */
class CometBehavior extends \CActiveRecordBehavior
{

    /**
     *
     * @var \CometModel 
     */
    protected $_comet = null;

    public function getComet()
    {

        if (is_null($this->_comet))
        {
            $this->_comet = new \CometModel();
        }
        return $this->_comet;
    }

    public function afterSave($event)
    {
        $type = $this->owner->isNewRecord ? \CometModel::NOTIFY_ADDED : \CometModel::NOTIFY_UPDATED;
        $this->comet->send($this->owner->userId, array('notification' => $this->owner->toJSON()), $type);

        return parent::afterSave($event);
    }

}

?>
