<?php

/**
 * This is the model class for table "message_log".
 *
 * The followings are the available columns in table 'message_log':
 * @property string $dialog_id
 * @property string $user_id
 * @property string $text
 * @property string $created
 * @property integer $read_status
 *
 * The followings are the available model relations:
 * @property MessageDialog $dialog
 * @property User $user
 */
class MessageLog extends CActiveRecord
{
    const TYPE_NEW_MESSAGE = 1;
    const TYPE_READ = 2;
    const TYPE_USER_WRITE = 3;
    const TYPE_STATUS_CHANGE = 5;

    /**
     * Returns the static model of the specified AR class.
     * @return MessageLog the static model class
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
        return 'message_log';
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
            array('dialog_id, user_id, text, created, read_status', 'safe', 'on' => 'search'),
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
            'dialog' => array(self::BELONGS_TO, 'MessageDialog', 'dialog_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
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

        $criteria->compare('dialog_id', $this->dialog_id, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('read_status', $this->read_status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->created = date("Y-m-d H:i:s");
        return parent::beforeSave();
    }

    /**
     * Create new message
     *
     * @static
     * @param $dialog_id
     * @param $user_id
     * @param string $text
     * @return MessageLog
     */
    static function NewMessage($dialog_id, $user_id, $text)
    {
        $message = new MessageLog();
        $message->dialog_id = $dialog_id;
        $message->text = $text;
        $message->user_id = $user_id;
        $message->save();

        //send to dialog users
        $users = MessageUser::model()->findAll('dialog_id=' . $dialog_id);
        foreach ($users as $user) {
            if ($user->user_id !== Yii::app()->user->getId()) {
                Yii::app()->comet->send(MessageCache::GetUserCache($user->user_id), array(
                    'message_id' => $message->id,
                    'dialog_id' => $dialog_id,
                    'type' => MessageLog::TYPE_NEW_MESSAGE,
                    'html' => Yii::app()->controller->renderPartial('_message', array(
                        'message' => $message->attributes,
                        'read' => 1,
                        'class'=>'dialog-message-new-in'
                    ), true)
                ));
            }
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
        $last_deleted = self::LastDeletedMessage($dialog_id);
        $models = Yii::app()->db->createCommand()
            ->select(array('id', 'user_id', 'text', 'created', 'read_status'))
            ->from('message_log');
        if (empty($last_deleted))
            $models = $models->where('dialog_id=:dialog_id AND id not in
                (SELECT message_id FROM message_deleted WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->getId()
            ));
        else
            $models = $models->where('dialog_id=:dialog_id AND id > :deleted_id AND id not in
                (SELECT message_id FROM message_deleted WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->getId(),
                ':deleted_id'=>$last_deleted
            ));

        $models = $models->order('id desc')
            ->limit(10)
            ->queryAll();

        //send comet-message to user who emails.
        MessageDialog::SetRead($dialog_id);
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
        $last_deleted = self::LastDeletedMessage($dialog_id);

        $models = Yii::app()->db->createCommand()
            ->select(array('id', 'user_id', 'text', 'created', 'read_status'))
            ->from('message_log');

        if (empty($last_deleted))
            $models = $models->where('dialog_id=:dialog_id AND id < :message_id AND id not in
                (SELECT message_id FROM message_deleted WHERE user_id = :user_id)', array(
            ':dialog_id' => $dialog_id,
            ':user_id' => Yii::app()->user->getId(),
            ':message_id' => $message_id
        ));
        else
            $models = $models->where('dialog_id=:dialog_id AND id < :message_id AND id > :deleted_id AND id not in
                (SELECT message_id FROM message_deleted WHERE user_id = :user_id)', array(
                ':dialog_id' => $dialog_id,
                ':user_id' => Yii::app()->user->getId(),
                ':message_id' => $message_id,
                ':deleted_id'=>$last_deleted
            ));

        $models = $models->order('id desc')
            ->limit(10)
            ->queryAll();

        return array_reverse($models);
    }

    public static function LastDeletedMessage($dialog_id)
    {
        $deleted = Yii::app()->db->createCommand()
            ->select(array('message_id'))
            ->from('message_dialog_deleted')
            ->where('dialog_id = :dialog_id AND user_id = :user_id', array(
            ':dialog_id' => $dialog_id,
            ':user_id' => Yii::app()->user->getId()
        ))
            ->queryScalar();

        return $deleted;
    }

    /**
     * @return bool
     */
    public function isMessageSentByUser()
    {
        if ($this->user_id == Yii::app()->user->getId())
            return true;
        return false;
    }

    /**
     * @static
     * @param string $time
     * @return string
     */
    public static function GetFormattedTime($time)
    {
        $result = '';
        if (date("Y:m:d", strtotime($time)) == date("Y:m:d"))
            $result .= 'Сегодня';
        elseif (date("Y", strtotime($time)) == date("Y"))
            $result .= date("j", strtotime($time)) . ' '
                . HDate::ruMonthShort(date("m", strtotime($time)));
        else
            $result .= date("Y", strtotime($time)) . '<br>' .
                date("j", strtotime($time)) . ' '
                . HDate::ruMonthShort(date("m", strtotime($time)));

        $result .= '<br/>';
        $result .= date("H:i", strtotime($time));

        return $result;
    }

    /**
     * @static
     * @param int $id
     */
    public static function removeMessage($id)
    {
        Yii::app()->db->createCommand()
            ->insert('message_deleted', array(
            'message_id' => $id,
            'user_id' => Yii::app()->user->getId(),
        ))
            ->execute();
    }
}