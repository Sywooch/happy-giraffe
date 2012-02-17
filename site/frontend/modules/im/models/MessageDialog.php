<?php

/**
 * This is the model class for table "message_dialog".
 *
 * The followings are the available columns in table 'message_dialog':
 * @property string $id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property MessageLog[] $messageLogs
 * @property MessageUser[] $messageUsers
 * @property MessageLog lastMessage
 * @property MessageDialogDeleted[] $lastDeletedMessage
 */
class MessageDialog extends CActiveRecord
{
    public $unreadByMe = 0;
    public $unreadByPal = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return MessageDialog the static model class
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
        return 'message_dialog';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title', 'safe', 'on' => 'search'),
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
            'messageLogs' => array(self::HAS_MANY, 'MessageLog', 'dialog_id'),
            'messageUsers' => array(self::HAS_MANY, 'MessageUser', 'dialog_id'),
            'lastMessage' => array(self::HAS_ONE, 'MessageLog', 'dialog_id', 'order' => 'lastMessage.id DESC'),
            'lastDeletedMessage' => array(self::HAS_ONE, 'MessageDialogDeleted', 'dialog_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
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
        $criteria->compare('title', $this->title, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @static
     * @param int $dialog_id
     * @param null|int $last_message_id
     */
    public static function SetRead($dialog_id, $last_message_id = null)
    {
        $has_unread = MessageLog::model()->find(array(
            'condition' => 'dialog_id=' . $dialog_id . ' AND user_id != ' . Yii::app()->user->getId()
                . ' AND read_status = 0',
        ));
        if ($has_unread === null)
            return;

        if ($last_message_id === null) {
            $last_message = MessageLog::model()->find(array(
                'condition' => 'dialog_id=' . $dialog_id . ' AND user_id != ' . Yii::app()->user->getId(),
                'order' => 'id DESC',
            ));
            if (empty($last_message))
                return;
            $last_message_id = $last_message->id;
        } else
            $last_message = MessageLog::model()->findByPk($last_message_id);

        $user_id = Yii::app()->user->getId();
        MessageLog::model()->updateAll(array('read_status' => '1'), 'dialog_id=' . $dialog_id
            . ' AND read_status=0 AND user_id != ' . $user_id . ' AND id <= ' . $last_message_id);

        Yii::app()->comet->send(MessageCache::GetUserCache($last_message->user_id), array(
            'message_id' => $last_message_id,
            'type' => MessageLog::TYPE_READ
        ));
    }

    /**
     * @static
     * @return MessageDialog[]
     */
    public static function GetUserNewDialogs()
    {
        $dialogs = self::GetUserDialogs();
        $new = array();
        foreach ($dialogs as $dialog) {
            if ($dialog->unreadByMe)
                $new [] = $dialog;
        }
        return $new;
    }

    /**
     * @static
     * @return MessageDialog[]
     */
    public static function GetUserOnlineDialogs()
    {
        $dialogs = self::GetUserDialogs();
        $online = array();
        foreach ($dialogs as $dialog) {
            if ($dialog->GetInterlocutor()->online)
                $online [] = $dialog;
        }
        return $online;
    }

    /**
     * @static
     * @return MessageDialog[]
     */
    public static function GetUserDialogs()
    {
        $dialogs = Im::model()->getNotEmptyDialogIds();

        if (empty($dialogs))
            return array();

        //load last messages
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $dialogs);
        $criteria->order = 'lastMessage.created desc';
        $dialogs = MessageDialog::model()->with(array(
            'lastMessage'
        ))->findAll($criteria);

        return self::CheckReadStatus($dialogs);
    }

    /**
     * @static
     * @param $dialogs MessageDialog[]
     * @return MessageDialog[]
     */
    static public function CheckReadStatus($dialogs)
    {
        $unread = self::UnreadDialogIds();
        $unreadByPal = self::UnreadByPalDialogIds();

        foreach ($dialogs as $dialog) {
            if (in_array($dialog->id, $unreadByPal)) {
                $dialog->unreadByPal = 1;
            } elseif (in_array($dialog->id, $unread)) {
                $dialog->unreadByMe = 1;
            }
        }

        return $dialogs;
    }

    public static function UnreadDialogIds()
    {
        return Yii::app()->db->createCommand()
            ->select('t.dialog_id')
            ->from(MessageUser::model()->tableName() . ' t')
            ->join(MessageLog::model()->tableName() . ' t2', 't2.dialog_id = t.dialog_id')
            ->where('t2.read_status = 0 AND t.user_id = ' . Yii::app()->user->getId()
            . ' AND t2.user_id != ' . Yii::app()->user->getId())
            ->queryColumn();
    }

    public static function UnreadByPalDialogIds()
    {
        return Yii::app()->db->createCommand()
            ->select('t.dialog_id')
            ->from(MessageUser::model()->tableName() . ' t')
            ->join(MessageLog::model()->tableName() . ' t2', 't2.dialog_id = t.dialog_id')
            ->where('t2.read_status = 0 AND t.user_id = ' . Yii::app()->user->getId()
            . ' AND t2.user_id = ' . Yii::app()->user->getId())
            ->queryColumn();
    }

    /**
     * @return User
     */
    public function GetInterlocutor()
    {
        foreach ($this->messageUsers as $messageUser) {
            if ($messageUser->user_id !== Yii::app()->user->getId())
                return $messageUser->user;
        }

        return null;
    }

    public function deleteDialog()
    {
        Yii::app()->db->createCommand()
            ->delete('message_dialog_deleted', 'dialog_id = :dialog_id AND user_id =:user_id', array(
            'dialog_id' => $this->id,
            'user_id' => Yii::app()->user->getId(),
        ));

        if (isset($this->lastMessage)) {
            $last_message = $this->lastMessage->id;

            Yii::app()->db->createCommand()
                ->insert('message_dialog_deleted', array(
                'dialog_id' => $this->id,
                'message_id' => $last_message,
                'user_id' => Yii::app()->user->getId(),
            ));
            Yii::app()->db->createCommand()
                ->update('message_log', array(
                    'read_status' => 1
                ),
                'dialog_id =:dialog_id AND user_id != :user_id AND read_status=0', array(
                    ':dialog_id' => $this->id,
                    ':user_id' => Yii::app()->user->getId(),
                )
            );
            Im::clearCache();
        }
        ActiveDialogs::model()->deleteDialog($this->id);
        return true;
    }

    static function getUnreadMessagesCount($id, $user_id = null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->getId();

        return Yii::app()->db->createCommand()
            ->select('count(t.id)')
            ->from(MessageLog::model()->tableName() . ' t')
            ->where('t.dialog_id = :dialog_id AND t.user_id != ' . $user_id
            . ' AND t.read_status = 0', array(
            ':dialog_id' => $id
        ))
            ->queryScalar();
    }
}