<?php

class UserSignal extends EMongoDocument
{
    const TYPE_NEW_USER_COMMENT = 1;
    const TYPE_NEW_USER_POST = 2;
    const TYPE_NEW_USER_VIDEO = 3;
    const TYPE_NEW_USER_TRAVEL = 4;
    const TYPE_NEW_USER_PHOTO = 5;
    const TYPE_NEW_USER_REGISTER = 6;

    const SIGNAL_UPDATE = 20;
    const SIGNAL_TAKEN = 21;
    const SIGNAL_DECLINE = 22;
    const SIGNAL_EXECUTED = 23;

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
            self::TYPE_NEW_USER_POST => 'Новый пост в сообществе. Нужно прокомментировать.',
            self::TYPE_NEW_USER_VIDEO => 'Новое видео в сообществе. Нужно прокомментировать.',
            self::TYPE_NEW_USER_TRAVEL => 'Новое путешествие в сообществе. Нужно прокомментировать.',
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
            $this->priority = 1;
            $this->status = self::STATUS_OPEN;
            if ($this->signal_type == self::TYPE_NEW_USER_POST) {
                $this->limits = array(rand(4, 6), rand(8, 12));
            }elseif ($this->signal_type == self::TYPE_NEW_USER_VIDEO) {
                $this->limits = array(rand(4, 6), rand(8, 12));
            }elseif ($this->signal_type == self::TYPE_NEW_USER_TRAVEL) {
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

    /**
     * @return bool
     */
    public function CurrentUserIsExecutor()
    {
        if (in_array(Yii::app()->user->getId(), $this->executors))
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function CurrentUserSuccessExecutor()
    {
        if (in_array(Yii::app()->user->getId(), $this->success))
            return true;
        return false;
    }

    /**
     * current user is not executor and didnt execute it earlier
     * @return bool
     */
    public function CurrentUserFree()
    {
        if (!in_array(Yii::app()->user->getId(), $this->success) && !in_array(Yii::app()->user->getId(), $this->executors))
            return true;
        return false;
    }

    /**
     * @param $user_id
     * @return bool
     */
    public function UserCanTake($user_id)
    {
        if (in_array($user_id, $this->executors))
            return false;

        $limit = $this->currentLimit();
        if (count($this->executors) + count($this->success) < $limit)
            return true;

        return false;
    }

    /**
     * @return int maximum executors
     */
    public function currentLimit()
    {
        if (count($this->limits) == 1)
            return $this->limits[0];

        return $this->limits[$this->priority - 1];
    }

    /**
     * @param $user_id
     */
    public function AddExecutor($user_id)
    {
        $this->executors[] = $user_id;
        if ($this->save()) {
            //send signal to moderators
            $moderators = AuthAssignment::model()->findAll('itemname="moderator"');
            foreach ($moderators as $moderator) {
                Yii::app()->comet->send(MessageCache::GetUserCache($moderator->userid), array(
                    'type' => self::SIGNAL_TAKEN,
                    'id' => $this->_id,
                ));
            }
        }
    }

    /**
     * Executor declined task
     * @param $user_id
     * @return bool
     */
    public function DeclineExecutor($user_id)
    {
        if (in_array($user_id, $this->executors)) {
            foreach ($this->executors as $key => $value)
                if ($value == $user_id)
                    unset($this->executors[$key]);

            if ($this->save()) {
                //send signal to moderators
                $moderators = AuthAssignment::model()->findAll('itemname="moderator"');
                foreach ($moderators as $moderator) {
                    Yii::app()->comet->send(MessageCache::GetUserCache($moderator->userid), array(
                        'type' => self::SIGNAL_DECLINE,
                        'id' => $this->_id,
                    ));
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Executor perfomed task
     * @param $user_id
     */
    public function TaskExecuted($user_id)
    {
        foreach ($this->executors as $key => $value)
            if ($value == $user_id)
                unset($this->executors[$key]);

        $this->success [] = $user_id;
        if (count($this->success) >= $this->currentLimit()){
            $this->success = array();
            $this->priority++;
            if ($this->priority > count($this->limits))
                $this->status = self::STATUS_CLOSED;
            $this->save();
            //send signal to moderators
            $moderators = AuthAssignment::model()->findAll('itemname="moderator"');
            foreach ($moderators as $moderator) {
                Yii::app()->comet->send(MessageCache::GetUserCache($moderator->userid), array(
                    'type' => self::SIGNAL_UPDATE
                ));
            }
        }else{
            $this->save();
            Yii::app()->comet->send(MessageCache::GetUserCache($user_id), array(
                'type' => self::SIGNAL_EXECUTED,
                'id'=>$this->_id,
            ));
        }
    }

    /**
     * @param $item_name
     * @param $item_id
     * @param $user_id
     */
    public static function CheckTask($item_name, $item_id, $user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->item_name('==', $item_name);
        $criteria->item_id('==', $item_id);

        $model = self::model()->find($criteria);
        if (isset($model)){
            $model->TaskExecuted($user_id);
        }
    }

    /**
     * @param Comment $comment
     */
    public static function CheckComment($comment)
    {
        if (Yii::app()->user->checkAccess('moderator')){
            self::CheckTask($comment->model, $comment->object_id, Yii::app()->user->getId());
        }
    }

    /**
     *
     */
    public function getSumPriority()
    {
        //складывается из:
        // 1. приоритета пользователя
        // 2. приоритета типа сигнала
        // 3. особенностей конкретного действия
    }
}
