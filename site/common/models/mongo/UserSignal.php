<?php

class UserSignal extends EMongoDocument
{
    const TYPE_NEW_USER_COMMENT = 1;
    const TYPE_NEW_USER_POST = 2;
    const TYPE_NEW_USER_PHOTO = 3;
    const TYPE_NEW_USER_REGISTER = 4;

    const SIGNAL_UPDATE = 20;
    const SIGNAL_TAKEN = 21;
    const SIGNAL_DECLINE = 22;

    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    public $user_id;
    public $signal_type;
    public $item_name;
    public $item_id;
    public $priority;
    public $status;
    public $executors = array();
    public $success = array();
    public $limits = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function signalTypes()
    {
        return array(
            self::TYPE_NEW_USER_COMMENT => 'Новый коммент',
            self::TYPE_NEW_USER_POST => 'Новый пост',
            self::TYPE_NEW_USER_PHOTO => 'Новое фото',
            self::TYPE_NEW_USER_REGISTER => 'Зарегистрировался',
        );
    }

    public function signalType()
    {
        $types = $this->signalTypes();
        return $types[$this->signal_type];
    }

    public function getCollectionName()
    {
        return 'userSignals';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_OPEN;
            if ($this->signal_type == self::TYPE_NEW_USER_POST) {
                $this->limits = array(rand(4, 6), rand(8, 12));
            }
        }
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            //send signal to moderators
            $moderators = AuthAssignment::model()->findAll('itemname="moderator"');
            foreach ($moderators as $moderator) {
                Yii::app()->comet->send(MessageCache::GetUserCache($moderator->userid), array(
                    'type' => self::SIGNAL_UPDATE
                ));
            }
        }
        return parent::afterSave();
    }

    /**
     * @return null|User
     */
    public function getUser()
    {
        if (!empty($this->user_id))
            return User::getUserById($this->user_id);
        return null;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        $class_name = $this->item_name;
        if (method_exists($class_name::model(), 'getLink'))
            return CHtml::link('перейти', Yii::app()->params['frontend_url'] . $class_name::getLink($this->item_id), array(
                'target' => '_blank'
            ));
        else
            return 'нет метода для вывода url';
    }

    public function CurrentUserIsExecutor()
    {
        if (in_array(Yii::app()->user->getId(), $this->executors))
            return true;
        return false;
    }
}
