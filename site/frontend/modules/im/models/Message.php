<?php

/**
 * Class Message
 *
 * Модель сообщения в сервисе "Личные сообщения"
 */

class Message extends HActiveRecord
{
    /**
     * Возвращает статическую модель конкретного класса Active Record
     *
     * @param string $className имя класса Active Record
     * @return Message статическая модель класса
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Возвращает название таблицы в базе данных
     *
     * @return string
     */
    public function tableName()
    {
        return 'im__messages';
    }

    /**
     * Возвращает список правил валидации для атрибутов модели
     *
     * @return array массив правил
     */
    public function rules()
    {
        return array(
            array('dialog_id', 'required'),
            array('read_status', 'numerical', 'integerOnly' => true),
            array('dialog_id, user_id', 'length', 'max' => 10),
            array('read_status', 'default', 'value' => 0),
            array('text, created', 'safe'),
            array('id, dialog_id, user_id, text, created, read_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * Возвращает список отношений сущности
     *
     * @return array массив отношений
     */
    public function relations()
    {
        return array(
            'deletedMessages' => array(self::HAS_MANY, 'DeletedMessage', 'message_id'),
            'last_dialog_deleted' => array(self::HAS_MANY, 'DialogDeleted', 'message_id'),
            'dialog' => array(self::BELONGS_TO, 'Dialog', 'dialog_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * Возвращает список поведений сущности
     *
     * @return array список
     */
    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            )
        );
    }

    /**
     * Событие, вызываемое после сохранения сообщения
     */
    public function afterSave()
    {
        Dialog::model()->updateByPk($this->dialog_id, array('last_message_id' => $this->id));

        //check moderator signal
        UserSignal::checkMessage($this);

        parent::afterSave();
    }

    /**
     * Создание нового сообщения
     *
     * @static
     * @param $dialog_id ID диалога
     * @param $user_id ID пользователя
     * @param string $text текст сообщения
     * @return Message модель сообщения
     */
    static function NewMessage($dialog_id, $user_id, $text)
    {
        $message = new Message();
        $message->dialog_id = $dialog_id;
        $message->text = $text;
        $message->user_id = $user_id;
        $message->save();
        //костыль для CTimestampBehavior
        $message->created = date("Y-m-d H:i:s");

        //send to dialog users
        $users = DialogUser::model()->findAll('dialog_id=' . $dialog_id);
        foreach ($users as $user) {
            if ($user->user_id !== Yii::app()->user->id) {
                $comet = new CometModel;
                $comet->type = CometModel::TYPE_NEW_MESSAGE;
                $comet->attributes = array(
                    'message_id' => $message->id,
                    'unread_count' => Im::model()->getUnreadMessagesCount(),
                    'dialog_id' => $dialog_id,
                    'html' => Yii::app()->controller->renderPartial('_message', array(
                        'message' => $message->attributes,
                        'read' => 1,
                        'class' => 'dialog-message-new-in'
                    ), true)
                );
                $comet->send($user->user_id);
            }
        }

        return $message;
    }

    /**
     * Возвращает список последних сообщений диалога
     *
     * @static
     * @param $dialog_id ID диалога
     * @return array массив моделей сообщений
     */
    static function GetLastMessages($dialog_id)
    {
        $last_deleted = self::LastDeletedMessageId($dialog_id);
        $models = Yii::app()->db->createCommand()
            ->select(array('id', 'user_id', 'text', 'created', 'read_status'))
            ->from('im__messages');
        if (empty($last_deleted))
            $models = $models->where('dialog_id=:dialog_id AND id not in
                (SELECT message_id FROM im__deleted_messages WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->id
            ));
        else
            $models = $models->where('dialog_id=:dialog_id AND id > :deleted_id AND id not in
                (SELECT message_id FROM im__deleted_messages WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->id,
                ':deleted_id' => $last_deleted
            ));

        $models = $models->order('id desc')
            ->limit(10)
            ->queryAll();

        //send comet-message to user who emails.
        Dialog::SetRead($dialog_id);
        return array_reverse($models);
    }

    /**
     * Возвращает список сообщений в диалоге, отправленных раньше определённого
     *
     * @static
     * @param $dialog_id ID диалога
     * @param $message_id ID сообщения
     * @return array массив моделей сообщений
     */
    static function GetMessagesBefore($dialog_id, $message_id)
    {
        $last_deleted = self::LastDeletedMessageId($dialog_id);

        $models = Yii::app()->db->createCommand()
            ->select(array('id', 'user_id', 'text', 'created', 'read_status'))
            ->from('im__messages');

        if (empty($last_deleted))
            $models = $models->where('dialog_id=:dialog_id AND id < :message_id AND id not in
                (SELECT message_id FROM im__deleted_messages WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->id,
                ':message_id' => $message_id
            ));
        else
            $models = $models->where('dialog_id=:dialog_id AND id < :message_id AND id > :deleted_id AND id not in
                (SELECT message_id FROM im__deleted_messages WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->id,
                ':message_id' => $message_id,
                ':deleted_id' => $last_deleted
            ));

        $models = $models->order('id desc')
            ->limit(10)
            ->queryAll();

        return array_reverse($models);
    }

    /**
     * Возвращает последнее удалённое сообщение в диалоге
     *
     * @static
     * @param $dialog_id ID диалога
     * @return int ID сообщения
     */
    public static function LastDeletedMessageId($dialog_id)
    {
        $deleted = Yii::app()->db->createCommand()
            ->select(array('message_id'))
            ->from('im__dialog_deleted')
            ->where('dialog_id = :dialog_id AND user_id = :user_id', array(
            ':dialog_id' => $dialog_id,
            ':user_id' => Yii::app()->user->id
        ))
            ->queryScalar();

        return $deleted;
    }

    /**
     * Является ли текущий пользователь автором сообщения
     *
     * @return bool
     */
    public function sent()
    {
        if ($this->user_id == Yii::app()->user->id)
            return true;
        return false;
    }

    /**
     * Удалить сообщение
     *
     * @static
     * @param int $id ID сообщения
     */
    public static function removeMessage($id)
    {
        Yii::app()->db->createCommand()
            ->insert('im__deleted_messages', array(
            'message_id' => $id,
            'user_id' => Yii::app()->user->id,
        ));
    }

    /**
     * Вспомогательный метод для сортировки сообщений
     *
     * @static
     * @param $a сообщение A
     * @param $b сообщений B
     * @return int
     */
    public static function sortMessages($a, $b)
    {
        return ($a->id < $b->id) ? -1 : 1;
    }

}