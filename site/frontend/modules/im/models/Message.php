<?php

/**
 * This is the model class for table "im__messages".
 *
 * The followings are the available columns in table 'im__messages':
 * @property string $id
 * @property string $dialog_id
 * @property string $user_id
 * @property string $text
 * @property string $created
 * @property integer $read_status
 *
 * The followings are the available model relations:
 * @property DeletedMessage[] $deletedMessages
 * @property DialogDeleted[] $last_dialog_deleted
 * @property Dialog $dialog
 * @property User $user
 */
class Message extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'im__messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('dialog_id', 'required'),
            array('read_status', 'numerical', 'integerOnly' => true),
            array('dialog_id, user_id', 'length', 'max' => 10),
            array('read_status', 'default', 'value' => 0),
            array('text, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, dialog_id, user_id, text, created, read_status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'deletedMessages' => array(self::HAS_MANY, 'DeletedMessage', 'message_id'),
            'last_dialog_deleted' => array(self::HAS_MANY, 'DialogDeleted', 'message_id'),
            'dialog' => array(self::BELONGS_TO, 'Dialog', 'dialog_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'dialog_id' => 'Dialog',
            'user_id' => 'User',
            'text' => 'Text',
            'created' => 'Created',
            'read_status' => 'Read Status',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('dialog_id', $this->dialog_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('read_status', $this->read_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

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

    public static function allMessagesForUser($dialog_id, $user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = ' t.dialog_id = :dialog_id
            AND t.user_id != :user_id
            AND t.id NOT IN (SELECT message_id FROM im__deleted_messages WHERE dialog_id = :dialog_id AND user_id = :user_id)
            AND t.id > COALESCE((SELECT message_id FROM im__dialog_deleted WHERE dialog_id = :dialog_id AND user_id = :user_id LIMIT 1), 0)
        ';
        //AND t.id > COALESCE((SELECT message_id FROM im__dialog_deleted WHERE dialog_id = :dialog_id AND user_id = :user_id LIMIT 1), 0)
        $criteria->params = array(
            ':dialog_id' => $dialog_id,
            ':user_id' => $user_id,
        );

        return Message::model()->findAll($criteria);
    }

    /**
     * Create new message
     *
     * @static
     * @param $dialog_id
     * @param $user_id
     * @param string $text
     * @return Message
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
                    'unread_count' => Im::getUnreadMessagesCount($user->user_id),
                    'dialog_id' => $dialog_id,
                    'html' => Yii::app()->controller->renderPartial('_message', array(
                        'message' => $message->attributes,
                        'read' => 1,
                        'class' => 'dialog-message-new-in'
                    ), true)
                );
                $comet->send($user->user_id);
            }
//            Im::clearCache($user->user_id);
        }

        return $message;
    }

    /**
     * @static
     * @param $dialog_id
     * @return array
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
     * @static
     * @param $dialog_id
     * @param $message_id
     * @return array
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
     * Last deleted Message id
     * @static
     * @param $dialog_id
     * @return int
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
     * @return bool
     */
    public function isMessageSentByUser()
    {
        if ($this->user_id == Yii::app()->user->id)
            return true;
        return false;
    }

    /**
     * @static
     * @param int $id
     */
    public static function removeMessage($id)
    {
        Yii::app()->db->createCommand()
            ->insert('im__deleted_messages', array(
            'message_id' => $id,
            'user_id' => Yii::app()->user->id,
        ))
            ->execute();
    }

    public static function getNotificationMessages($user_id)
    {
        $dialogs = User::getUserById($user_id)->userDialogs;
        $dialog_ids = array();
        foreach($dialogs as $dialogs)
            $dialog_ids[]=$dialogs->dialog_id;
        if (count($dialog_ids) == 0)
            return array('data' => array(), 'count' => 0);

        $models = Yii::app()->db->createCommand()
            ->select(array('t.id', 't.user_id', 't.text', 't.created', 't.read_status', 't.dialog_id'))
            ->from('im__messages as t')
            ->where(' t.dialog_id IN (:dialogs) AND t.user_id != :user_id AND t.id not in (SELECT message_id FROM im__deleted_messages WHERE user_id = :user_id) ', array(
            ':user_id' => $user_id,
            ':dialogs' => implode(',', $dialog_ids)
        ))
            ->order('message_log.id desc')
            ->limit(3)
            ->queryAll();

        $data = array();
        foreach ($models as $m) {
            $data[] = array(
                'text' => self::getNotificationText($m),
                'url' => Yii::app()->createUrl('/im/default/dialog', array('id' => $m['dialog_id'])),
            );
        }

        $new_count = Im::getUnreadMessagesCount($user_id);

        return array('data' => $data, 'count' => $new_count);
    }

    public static function sortMessages($a, $b)
    {
        return ($a->id < $b->id) ? -1 : 1;
    }

    public static function getNotificationText($message)
    {
        $user = User::getUserById($message['user_id']);
        return '<span class="name">' . $user->fullName . '</span><span class="text">'
            . strip_tags($message['text']) . '</span><span class="date">'
            . HDate::GetFormattedTime($message['created']) . '</span>';
    }

}