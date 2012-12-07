<?php

/**
 * This is the model class for table "im__dialogs".
 *
 * The followings are the available columns in table 'im__dialogs':
 * @property string $id
 * @property string $title
 * @property int $last_message_id
 *
 * The followings are the available model relations:
 * @property DialogDeleted $lastDeleted
 * @property DialogUser[] $dialogUsers
 * @property Message $lastMessage
 * @property Message[] $messages
 */
class Dialog extends HActiveRecord
{
    public $unreadByMe = 0;
    public $unreadByPal = 0;
    public $unreadMessagesCount;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Dialog the static model class
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
        return 'im__dialogs';
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
            'lastDeleted' => array(self::HAS_ONE, 'DialogDeleted', 'dialog_id'),
            'dialogUsers' => array(self::HAS_MANY, 'DialogUser', 'dialog_id'),
            'messages' => array(self::HAS_MANY, 'Message', 'dialog_id'),
            'lastMessage' => array(self::BELONGS_TO, 'Message', 'last_message_id'),
            'deletedMessages' => array(self::HAS_MANY, 'DeletedMessage', 'dialog_id'),
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

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
        );
    }

    /**
     * @static
     * @param int $dialog_id
     * @param null|int $last_message_id
     */
    public static function SetRead($dialog_id, $last_message_id = null)
    {
        $has_unread = Message::model()->find(array(
            'condition' => 'dialog_id=' . $dialog_id . ' AND user_id != ' . Yii::app()->user->id
                . ' AND read_status = 0',
        ));
        if ($has_unread === null)
            return;

        if ($last_message_id === null) {
            $last_message = Message::model()->find(array(
                'condition' => 'dialog_id=' . $dialog_id . ' AND user_id != ' . Yii::app()->user->id,
                'order' => 'id DESC',
            ));
            if (empty($last_message))
                return;
            $last_message_id = $last_message->id;
        } else
            $last_message = Message::model()->findByPk($last_message_id);

        $user_id = Yii::app()->user->id;
        Message::model()->updateAll(array('read_status' => '1'), 'dialog_id=' . $dialog_id
            . ' AND read_status=0 AND user_id != ' . $user_id . ' AND id <= ' . $last_message_id);

        //if user read all messages - update mail delivery
        $unread = Im::model($user_id)->getUnreadMessagesCount($user_id);
        if ($unread == 0) {
            $m_criteria = new EMongoCriteria;
            $m_criteria->type('==', MailDelivery::TYPE_IM);
            $m_criteria->user_id('==', (int)$user_id);
            MailDelivery::model()->deleteAll($m_criteria);
        }

        $comet = new CometModel();
        $comet->type = CometModel::TYPE_MESSAGE_READ;
        $comet->attributes = array('message_id' => $last_message_id);
        $comet->send($last_message->user_id);
    }

    /**
     * @static
     * @return Dialog[]
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
     * @return Dialog[]
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
     * @return Dialog[]
     */
    public static function GetUserDialogs()
    {
        $dialogs = Yii::app()->db->createCommand(
            'SELECT distinct(dialog_id) FROM ' . DialogUser::model()->tableName() . ' WHERE user_id=' . Yii::app()->user->id . ''
        )->queryColumn();

        if (empty($dialogs))
            return array();

        //load last messages
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $dialogs);
        $criteria->order = 'lastMessage.id desc';
        $dialogs = Dialog::model()->with(array(
            'lastMessage', 'lastDeleted', 'dialogUsers'
        ))->findAll($criteria);

        //remove empty dialogs
        $notEmptyDialogs = array();
        foreach ($dialogs as $dialog) {
            if (!empty($dialog->lastMessage)) {
                if (!empty($dialog->lastDeleted)) {
                    if ($dialog->lastDeleted->message_id < $dialog->lastMessage->id)
                        $notEmptyDialogs [] = $dialog;
                } else
                    $notEmptyDialogs [] = $dialog;
            }
        }

        return self::CheckReadStatus($notEmptyDialogs);
    }

    /**
     * @static
     * @param $dialogs Dialog[]
     * @return Dialog[]
     */
    static public function CheckReadStatus($dialogs)
    {
        $unread = self::UnreadDialogIds();
        $unreadByPal = self::UnreadByPalDialogIds();

        foreach ($dialogs as $dialog) {
            if (in_array($dialog->id, $unreadByPal)) {
                $dialog->unreadByPal = 1;
            }
            if (in_array($dialog->id, $unread)) {
                $dialog->unreadByMe = 1;
            }
        }

        return $dialogs;
    }

    public static function UnreadDialogIds()
    {
        return Yii::app()->db->createCommand()
            ->select('t.dialog_id')
            ->from(DialogUser::model()->tableName() . ' t')
            ->join(Message::model()->tableName() . ' t2', 't2.dialog_id = t.dialog_id')
            ->where('t2.read_status = 0 AND t.user_id = ' . Yii::app()->user->id
            . ' AND t2.user_id != ' . Yii::app()->user->id)
            ->queryColumn();
    }

    public static function UnreadByPalDialogIds()
    {
        return Yii::app()->db->createCommand()
            ->select('t.dialog_id')
            ->from(DialogUser::model()->tableName() . ' t')
            ->join(Message::model()->tableName() . ' t2', 't2.dialog_id = t.dialog_id')
            ->where('t2.read_status = 0 AND t.user_id = ' . Yii::app()->user->id
            . ' AND t2.user_id = ' . Yii::app()->user->id)
            ->queryColumn();
    }

    /**
     * @return User
     */
    public function GetInterlocutor()
    {
        foreach ($this->dialogUsers as $DialogUser) {
            if ($DialogUser->user_id !== Yii::app()->user->id)
                return User::getUserById($DialogUser->user_id);
        }

        return null;
    }

    public function deleteDialog()
    {
        Yii::app()->db->createCommand()
            ->delete('im__dialog_deleted', 'dialog_id = :dialog_id AND user_id =:user_id', array(
            'dialog_id' => $this->id,
            'user_id' => Yii::app()->user->id,
        ));

        if ($this->lastMessage !== null) {
            $last_message = $this->lastMessage->id;

            Yii::app()->db->createCommand()
                ->insert(DialogDeleted::model()->tableName(), array(
                'dialog_id' => $this->id,
                'message_id' => $last_message,
                'user_id' => Yii::app()->user->id,
            ));
            Yii::app()->db->createCommand()
                ->update(Message::model()->tableName(), array(
                    'read_status' => 1
                ),
                'dialog_id =:dialog_id AND user_id != :user_id AND read_status=0', array(
                    ':dialog_id' => $this->id,
                    ':user_id' => Yii::app()->user->id,
                )
            );

            //remove deleted messages
            $deleted_messages = DeletedMessage::model()->with('message')->findAllByAttributes(array('user_id' => Yii::app()->user->id));
            foreach ($deleted_messages as $deleted_message) {
                if ($deleted_message->message->dialog_id == $this->id)
                    $deleted_message->delete();
            }
        }
        ActiveDialogs::model()->deleteDialog($this->id);
        return true;
    }

    static function getUnreadMessagesCount($id, $user_id = null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->id;

        return Yii::app()->db->createCommand()
            ->select('count(t.id)')
            ->from(Message::model()->tableName() . ' t')
            ->where('t.dialog_id = :dialog_id AND t.user_id != ' . $user_id
            . ' AND t.read_status = 0', array(
            ':dialog_id' => $id
        ))
            ->queryScalar();
    }

    public function markAsReadFrom($interlocutor_id)
    {
        Message::model()->updateAll(array('read_status' => 1), 'user_id = :interlocutor_id AND dialog_id = :dialog_id', array(
            ':interlocutor_id' => $interlocutor_id,
            ':dialog_id' => $this->id,
        ));

        $comet = new CometModel;
        $comet->type = CometModel::TYPE_DIALOG_READ;
        $comet->attributes = array(
            'dialog_id' => $this->id,
        );
        $comet->send($interlocutor_id);
    }

    public function withSimpleUser()
    {
        $user_ids = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('im__dialog_users')
            ->where('dialog_id=:dialog_id', array(':dialog_id' => $this->id))
            ->queryColumn();

        foreach ($user_ids as $user_id){
            $model = User::model()->resetScope()->findByPk($user_id);
            if ($model !== null && $model->group == UserGroup::USER)
                return true;
        }

        return false;
    }
}