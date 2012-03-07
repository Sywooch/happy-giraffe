<?php

class UserSignal extends EMongoDocument
{
    const TYPE_NEW_USER_POST = 2;
    const TYPE_NEW_USER_VIDEO = 3;
    const TYPE_NEW_USER_PHOTO = 5;
    const TYPE_NEW_USER_REGISTER = 6;
    const TYPE_NEW_BLOG_POST = 7;

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
    public $all_success = array();
    public $limits = array();
    public $created;
    public $created_time;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function signalTypes()
    {
        return array(
            self::TYPE_NEW_USER_POST => 'Запись в клубе',
            self::TYPE_NEW_USER_VIDEO => 'Видео в клубе',
            self::TYPE_NEW_USER_PHOTO => 'Фото в анкете',
            self::TYPE_NEW_USER_REGISTER => 'Новый пользователь',
            self::TYPE_NEW_BLOG_POST => 'Запись в блоге',
        );
    }

    public function signalWants()
    {
        return array(
            self::TYPE_NEW_USER_POST => 'Прокомментировать',
            self::TYPE_NEW_USER_VIDEO => 'Прокомментировать',
            self::TYPE_NEW_USER_PHOTO => 'Прокомментировать',
            self::TYPE_NEW_USER_REGISTER => 'Написать в гостевую',
            self::TYPE_NEW_BLOG_POST => 'Прокомментировать',
        );
    }

    public function signalType()
    {
        $types = $this->signalTypes();
        return $types[$this->signal_type];
    }

    public function signalWant()
    {
        $types = $this->signalWants();
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
            $this->created = date("Y-m-d");
            $this->created_time = date("H:i");
            if ($this->signal_type == self::TYPE_NEW_USER_POST) {
                $this->limits = array(rand(4, 6), rand(8, 12));
            } elseif ($this->signal_type == self::TYPE_NEW_USER_VIDEO) {
                $this->limits = array(rand(4, 6), rand(8, 12));
            } elseif ($this->signal_type == self::TYPE_NEW_USER_PHOTO) {
                $this->limits = array(rand(4, 6), rand(8, 12));
            } elseif ($this->signal_type == self::TYPE_NEW_USER_REGISTER) {
                $this->limits = array(rand(1, 4));
            }
        }
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            UserSignal::SendUpdateSignal();
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
        return CHtml::link('перейти', $this->getUrl(), array('target' => '_blank'));
    }

    public function getUrl()
    {
        $class_name = $this->item_name;
        if (method_exists($class_name::model(), 'getUrl'))
            return $class_name::model()->findByPk($this->item_id)->getUrl();
        else
            return 'error';
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
            $this->sendTakeSignal();
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
                $this->sendDeclineSignal();

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
        $has_task = false;
        foreach ($this->executors as $key => $value)
            if ($value == $user_id) {
                unset($this->executors[$key]);
                $has_task = true;
            }

        if (!$has_task)
            return;

        $this->success [] = $user_id;
        if (!in_array($user_id, $this->all_success))
            $this->all_success [] = $user_id;

        UserSignalHistory::TaskSuccess($this, $user_id);

        if (count($this->success) >= $this->currentLimit()) {
            $this->success = array();
            $this->priority++;
            if ($this->priority > count($this->limits))
                $this->status = self::STATUS_CLOSED;
            $this->save();

            UserSignal::SendUpdateSignal();
        } else {
            $this->save();

            $comet = new CometModel();
            $comet->type = CometModel::TYPE_SIGNAL_EXECUTED;
            $comet->attributes = array('id' => $this->_id);
            $comet->send($user_id);
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
        if (isset($model)) {
            $model->TaskExecuted($user_id);
        }
    }

    /**
     * @param Comment $comment
     */
    public static function CheckComment($comment)
    {
        if (Yii::app()->user->checkAccess('user_signals')) {
            self::CheckTask($comment->entity, $comment->entity_id, Yii::app()->user->getId());
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

    /**
     * @param int $user_id
     * @param string $date
     * @param int $limit
     * @return array
     */
    public function getHistory($user_id, $date, $limit = null)
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('all_success', 'all', array($user_id));
        $criteria->created('==', $date);
        //$criteria->status('==', self::STATUS_CLOSED);
        if ($limit !== null)
            $criteria->limit($limit);
        $criteria->sort('_id', EMongoCriteria::SORT_DESC);

        return self::model()->findAll($criteria);
    }

    public function getHistoryText()
    {
        $text = 'Прокомментировал ';
        if ($this->signal_type == self::TYPE_NEW_USER_POST) {
            $text .= CHtml::link('Запись в клубе', $this->getUrl());
        } elseif ($this->signal_type == self::TYPE_NEW_BLOG_POST) {
            $text .= CHtml::link('Запись в блоге', '#');
        } elseif ($this->signal_type == self::TYPE_NEW_USER_VIDEO) {
            $text .= CHtml::link('Видео в клубе', $this->getLink());
        } elseif ($this->signal_type == self::TYPE_NEW_USER_PHOTO) {
            $text .= CHtml::link('Фото в анкете', '#');
        } elseif ($this->signal_type == self::TYPE_NEW_USER_REGISTER) {
            $text = 'Написал в гостевую ' . CHtml::link('Анкета пользователя',
                Yii::app()->createUrl('user/profile', array('user_id' => $this->user_id)));
        }

        $user = $this->getUser();
        if ($user !== null)
            $text .= ' от ' . CHtml::link($user->getFullName(), Yii::app()->createUrl('user/profile', array('user_id' => $user->id)));

        return $text;
    }

    public function getIcon()
    {
        if ($this->signal_type == self::TYPE_NEW_USER_POST) {
            return 'icon-cpost';
        } elseif ($this->signal_type == self::TYPE_NEW_BLOG_POST) {
            return 'icon-bpost';
        } elseif ($this->signal_type == self::TYPE_NEW_USER_VIDEO) {
            return 'icon-video';
        } elseif ($this->signal_type == self::TYPE_NEW_USER_PHOTO) {
            return 'icon-photo';
        } elseif ($this->signal_type == self::TYPE_NEW_USER_REGISTER) {
            return 'icon-user';
        }

        return '';
    }

    public static function SendUpdateSignal()
    {
        $moderators = AuthAssignment::model()->findAll('itemname="moderator"');

        $comet = new CometModel();
        $comet->type = CometModel::TYPE_SIGNAL_UPDATE;
        foreach ($moderators as $moderator) {
            $comet->send($moderator->userid);
        }
    }

    public function sendDeclineSignal()
    {
        $moderators = AuthAssignment::model()->findAll('itemname="moderator"');

        $comet = new CometModel();
        $comet->type = CometModel::TYPE_SIGNAL_DECLINE;
        $comet->attributes = array('id' => $this->_id);
        foreach ($moderators as $moderator) {
            $comet->send($moderator->userid);
        }
    }

    public function sendTakeSignal()
    {
        $moderators = AuthAssignment::model()->findAll('itemname="moderator"');

        $comet = new CometModel();
        $comet->type = CometModel::TYPE_SIGNAL_TAKEN;
        $comet->attributes = array('id' => $this->_id);
        foreach ($moderators as $moderator) {
            $comet->send($moderator->userid);
        }
    }
}