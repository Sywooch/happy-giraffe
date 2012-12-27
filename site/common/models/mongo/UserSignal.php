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

    /**
     * @var int пользователь инициатор задания
     */
    public $user_id;
    /**
     * @var int тип сигнала
     */
    public $signal_type;
    /**
     * @var Название класса
     */
    public $item_name;
    /**
     * @var int id элемента который создал пользователь
     */
    public $item_id;
    /**
     * @var int приоритет задания
     */
    public $priority = 1;
    /**
     * @var int приоритет пользователя-инициатора
     */
    public $user_priority;
    /**
     * @var int открыто/закрыто
     */
    public $status;
    /**
     * @var array массив модераторов, которые взяли задание на выполнение
     */
    public $executors = array();
    /**
     * @var array user_id модераторов которые успешно выполнили это задание
     */
    public $success = array();
    /**
     * @var array необходимое количество исполнителей задания
     */
    public $limits = array();
    /**
     * @var bool Может ли исполнитель взять это задание
     */
    public $full = false;
    /**
     * @var bool повторное задание на одно и тоже действие
     */
    public $repeat_task = false;
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
            self::TYPE_NEW_USER_REGISTER => 'Написать личное сообщение',
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
        return 'user_signals';
    }

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->status = self::STATUS_OPEN;
            $this->created = date("Y-m-d");
            $this->created_time = date("H:i");
            $this->user_priority = (int)$this->getUser()->getUserPriority();

            if (!$this->repeat_task) {
                if ($this->signal_type == self::TYPE_NEW_USER_POST) {
                    $this->limits = array(rand(4, 6), rand(4, 6));
                } elseif ($this->signal_type == self::TYPE_NEW_USER_VIDEO) {
                    $this->limits = array(rand(4, 6), rand(4, 6));
                } elseif ($this->signal_type == self::TYPE_NEW_BLOG_POST) {
                    $this->limits = array(rand(4, 6), rand(4, 6));
                } elseif ($this->signal_type == self::TYPE_NEW_USER_PHOTO) {
                    $this->limits = array(rand(4, 6), rand(4, 6));
                } elseif ($this->signal_type == self::TYPE_NEW_USER_REGISTER) {
                    $this->limits = array(3, rand(3, 4));
                }
            }
        }
        return parent::beforeSave();
    }

    public function afterSave()
    {
        if ($this->isNewRecord) {
            UserSignal::sendUpdateSignal(null, true);
        }
        parent::afterSave();
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
        if ($this->signal_type == self::TYPE_NEW_USER_REGISTER) {
            $user = $this->getUser();

            if ($user === null || $user->deleted == 1)
            {
                $this->delete();
                return 'error';
            }
            return $user->getUrl();
        } else {
            $class_name = $this->item_name;
            if (method_exists($class_name::model(), 'getUrl')) {
                $user = $class_name::model()->findByPk($this->item_id);
                if ($user === null || (isset($user->deleted) && $user->deleted == 1)){
                    $this->delete();
                    return 'error';
                }
                else
                    return $user->getUrl();
            }
            else
            {
                $this->delete();
                return 'error';
            }
        }
    }

    /**
     * @return bool
     */
    public function CurrentUserIsExecutor()
    {
        if (in_array(Yii::app()->user->id, $this->executors))
            return true;
        return false;
    }

    /**
     * @return bool
     */
    public function CurrentUserSuccessExecutor()
    {
        if (in_array(Yii::app()->user->id, $this->success))
            return true;
        return false;
    }

    /**
     * current user is not executor and didnt execute it earlier
     * @return bool
     */
    public function CurrentUserFree()
    {
        if (!in_array(Yii::app()->user->id, $this->success) && !in_array(Yii::app()->user->id, $this->executors))
            return true;
        return false;
    }

    /**
     * @return int maximum executors
     */
    public function currentLimit()
    {
        return $this->limits[0];
    }

    /**
     * @param $user_id
     */
    public function AddExecutor($user_id)
    {
        if ($this->full)
            return false;

        $this->executors[] = (int)$user_id;
        if (count($this->executors) + count($this->success) >= $this->currentLimit())
            $this->full = true;
        if ($this->save()) {
            if ($this->full)
                $this->sendUpdateSignal();
        }

        $response = new UserSignalResponse;
        $response->user_id = (int)$user_id;
        $response->task_id = $this->_id;
        $response->save();
    }

    /**
     * Executor declined task
     * @param $user_id
     * @return bool
     */
    public function DeclineExecutor($user_id)
    {
        if (in_array($user_id, $this->executors)) {
            UserSignalResponse::Decline($this, $user_id);

            $wasFull = $this->full;
            foreach ($this->executors as $key => $value)
                if ($value == $user_id)
                    unset($this->executors[$key]);

            if (count($this->executors) + count($this->success) < $this->currentLimit())
                $this->full = false;

            if ($this->save()) {
                if ($wasFull && !$this->full)
                    $this->sendUpdateSignal();

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
        $this->executors = array_merge($this->executors, array());

        if (!$has_task)
            return;

        $this->success [] = (int)$user_id;
        UserSignalHistory::TaskSuccess($this, $user_id);
        UserSignalResponse::TaskSuccess($this, $user_id);

        if (count($this->success) >= $this->currentLimit() && empty($this->executors)) {
            //если больше лимита, закрываем это задание и формируем новое с пониженным приоритетом если необходимо
            if (count($this->limits) > 1) {
                $new_signal = new UserSignal();
                $new_signal->user_id = $this->user_id;
                $new_signal->signal_type = $this->signal_type;
                $new_signal->item_id = $this->item_id;
                $new_signal->item_name = $this->item_name;
                $new_signal->priority = $this->priority + 1;
                $limits = $this->limits;
                array_shift($limits);
                $new_signal->limits = $limits;
                $new_signal->repeat_task = true;
                $new_signal->save();
            }

            $this->status = self::STATUS_CLOSED;
            $this->save();

            UserSignal::sendUpdateSignal();
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
        if ($item_name == 'BlogContent')
            $item_name = 'CommunityContent';
        $criteria = new EMongoCriteria;
        $criteria->item_name('==', $item_name);
        $criteria->item_id('==', (int)$item_id);
        $criteria->status('==', self::STATUS_OPEN);

        $model = self::model()->find($criteria);
        if (isset($model)) {
            $model->TaskExecuted((int)$user_id);
        }
    }

    /**
     * @param Comment $comment
     */
    public static function CheckComment($comment)
    {
        if (Yii::app()->user->checkAccess('user_signals')) {
            Yii::import('site.frontend.modules.signal.models.*');
            self::CheckTask($comment->entity, $comment->entity_id, Yii::app()->user->id);
        }
    }

    /**
     * @param Message $message
     */
    public static function checkMessage($message)
    {
        if (Yii::app()->user->checkAccess('user_signals')) {
            Yii::import('site.frontend.modules.signal.models.*');
            self::CheckTask('User', $message->dialog->GetInterlocutor()->id, Yii::app()->user->id);
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
        $criteria->user_id('==', (int)$user_id);
        $criteria->status('==', UserSignalResponse::STATUS_SUCCESS_CLOSE);
        $criteria->date('==', $date);
        $criteria->sort('_id', EMongoCriteria::SORT_DESC);
//        if ($limit !== null)
//            $criteria->limit($limit);

        return UserSignalResponse::model()->findAll($criteria);
    }

    public function getHistoryText()
    {
        $text = 'Прокомментировал ';
        if ($this->signal_type == self::TYPE_NEW_USER_POST) {
            $text .= CHtml::link('Запись в клубе', $this->getUrl(), array('target' => '_blank'));
        } elseif ($this->signal_type == self::TYPE_NEW_BLOG_POST) {
            $text .= CHtml::link('Запись в блоге', $this->getUrl(), array('target' => '_blank'));
        } elseif ($this->signal_type == self::TYPE_NEW_USER_VIDEO) {
            $text .= CHtml::link('Видео в клубе', $this->getUrl(), array('target' => '_blank'));
        } elseif ($this->signal_type == self::TYPE_NEW_USER_PHOTO) {
            $text .= CHtml::link('Фото в анкете', $this->getUrl(), array('target' => '_blank'));
        } elseif ($this->signal_type == self::TYPE_NEW_USER_REGISTER) {
            $text = 'Написал личное сообщение ';
        }

        $user = $this->getUser();
        if ($user !== null)
            $text .= ' от ' . CHtml::link($user->getFullName(), $user->getUrl(), array('target' => '_blank'));

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

    public static function sendUpdateSignal($user_id = null, $sound = false)
    {
        $comet = new CometModel();
        $comet->type = CometModel::TYPE_SIGNAL_UPDATE;
        $comet->attributes = array('sound' => $sound);
        if ($user_id === null) {
            $moderators = AuthAssignment::model()->findAll('itemname="moderator"');
            foreach ($moderators as $moderator)
                $comet->send($moderator->userid);

            $super_m = AuthAssignment::model()->findAll('itemname="supermoderator"');
            foreach ($super_m as $moderator)
                $comet->send($moderator->userid);

            $admins = AuthAssignment::model()->findAll('itemname="administrator"');
            foreach ($admins as $admin)
                $comet->send($admin->userid);
        } else {
            $comet->send($user_id);
        }
    }


    /**
     * Close signals for removed items
     *
     * @static
     * @param CActiveRecord $entity
     * @param bool $sendSignal
     * @return void
     */
    public static function closeRemoved($entity, $sendSignal = true){
        $criteria = new EMongoCriteria;
        $criteria->item_id('==', (int)$entity->primaryKey);
        $criteria->item_name('==', get_class($entity));

        $models = self::model()->findAll($criteria);
        foreach ($models as $model) {
            $model->status = self::STATUS_CLOSED;
            $model->save();
        }
        if (count($models) > 0 && $sendSignal)
            self::sendUpdateSignal();
    }
}