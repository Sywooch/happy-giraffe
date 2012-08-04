<?php

/**
 * Store in cache user dialogs with opponents
 */
class Im
{
    /*
     * Instance for each user
     */
    protected static $instances = array();

    /**
     * @var int|null user for whom we create this instance
     */
    private $_user_id;

    private $dialog_counts = null;
    private $unread_counts = null;

    /**
     * @param null|int $user_id
     */
    private function __construct($user_id = null)
    {
        if ($user_id === null)
            $this->_user_id = Yii::app()->user->id;
        else
            $this->_user_id = $user_id;
    }

    /**
     * @static
     * @param null|int $user_id
     * @return Im
     */
    public static function model($user_id = null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->id;

        if (!isset(self::$instances[$user_id])) {
            self::$instances[$user_id] = new Im($user_id);
        }
        return self::$instances[$user_id];
    }

    /**
     * Search users from dialogs
     *
     * @param $term
     * @return array
     */
    public function findDialogUserNames($term)
    {
        /*$term = strtolower($term);
        $result = array();
        foreach ($this->_dialog_users as $user_id) {
            $user = $this->getUser($user_id);
            if ($this->startsWith($user->first_name, $term) || $this->startsWith($user->last_name, $term)
                || $this->startsWith($user->first_name . ' ' . $user->last_name, $term)
                || $this->startsWith($user->last_name . ' ' . $user->first_name, $term)
            ) {
                $result[] = $user->getFullName();
            }
        }

        return $result;*/
    }

    /**
     * Find dialog by interlocutor's name
     * @param $name
     * @return null|int
     */
    public function findDialog($name)
    {
        /*foreach ($this->_dialogs as $dialog) {
            $pal_id = $dialog['users'][0];
            if (mb_strtolower($this->getUser($pal_id)->getFullName(), 'utf-8') == mb_strtolower($name, 'utf-8')) {
                return $dialog['id'];
            }
        }*/

        return null;
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        $haystack = mb_strtolower($haystack, 'utf-8');
        return (substr($haystack, 0, $length) === $needle);
    }

    public function getUnreadMessagesCount()
    {
        if ($this->unread_counts !== null)
            return $this->unread_counts;

        return Yii::app()->db->createCommand()
            ->select('COUNT( id )')
            ->from(Message::model()->tableName())
            ->where('`dialog_id` IN (SELECT DISTINCT (dialog_id) FROM im__dialog_users WHERE user_id = :user_id) AND user_id != :user_id AND read_status = 0', array(':user_id' => $this->_user_id))
            ->queryScalar();
    }

    /**
     * Return count of not empty dialogs and count of online dialogs
     *
     * @static
     * @return array dialog_id[]
     */
    public function getDialogsCountAndOnlineDialogsCount()
    {
        if ($this->dialog_counts !== null)
            return $this->dialog_counts;

        $dialogUsers = $this->getDialogUsers();

        $all_count = 0;
        $online_count = 0;

        foreach ($dialogUsers as $dialogUser) {
            //check on deleted dialog
            if ($dialogUser->user_id == $this->_user_id) {
                if ($dialogUser->dialog->lastMessage === null){
                    continue;
                }
                $dialog = $dialogUser->dialog;
                if (isset($dialog->lastDeleted) && $dialog->lastDeleted->user_id == $this->_user_id) {
                    if ($dialog->lastDeleted->message_id == $dialogUser->dialog->lastMessage->id)
                        $all_count--;
                }
                $all_count++;
            }

            //check online status
            if ($dialogUser->user_id != $this->_user_id) {
                if ($dialogUser->user->online)
                    $online_count++;
            }
        }

        return array($all_count, $online_count);
    }

    /**
     * @return DialogUser[]
     */
    public function getDialogUsers()
    {
        return DialogUser::model()->with(array(
            'dialog.lastDeleted' => array(
                'select' => array('message_id', 'user_id')
            ),
            'dialog.lastMessage' => array(
                'select' => array('id', 'user_id', 'read_status')
            ),
            'dialog' => array(
                'select' => array('id', 'last_message_id'),
            ),
            'user',
        ))->findAll('t.dialog_id IN (SELECT distinct(dialog_id) FROM ' . DialogUser::model()->tableName() . ' WHERE user_id=' . $this->_user_id . ')');
    }

    /**
     * @static
     * @return array
     */
    public function getNotificationMessages()
    {
        $models = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Message::model()->tableName())
            ->where('`dialog_id` IN (SELECT DISTINCT (dialog_id) FROM im__dialog_users WHERE user_id = :user_id) AND user_id != :user_id', array(':user_id' => $this->_user_id))
            ->order('id desc')
            ->limit(3)
            ->queryAll();

        $data = array();
        foreach ($models as $m) {
            $data[] = array(
                'text' => self::getNotificationText($m),
                'url' => Yii::app()->createUrl('/im/default/dialog', array('id' => $m['dialog_id'])),
            );
        }

        $new_count = Im::model()->getUnreadMessagesCount();

        return array('data' => $data, 'count' => $new_count);
    }

    /**
     * @static
     * @param $message
     * @return string
     */
    public static function getNotificationText($message)
    {
        $user = User::getUserById($message['user_id']);
        return '<span class="name">' . CHtml::encode($user->fullName) . '</span><span class="text">'
            . strip_tags(Str::truncate($message['text'], 150)) . '</span><span class="date">'
            . HDate::GetFormattedTime($message['created']) . '</span>';
    }

    public function GetDialogUser($dialog_id)
    {
        $user_id = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from(DialogUser::model()->tableName())
            ->where('`dialog_id` = :dialog_id AND user_id != :user_id',
            array(
                ':user_id' => $this->_user_id,
                ':dialog_id' => $dialog_id
            ))
            ->queryScalar();

        return User::getUserById($user_id);
    }

    public function getDialogIdByUser($pal_id)
    {
        $dialogs = Yii::app()->db->createCommand()
            ->select('*')
            ->from(DialogUser::model()->tableName())
            ->where('user_id = :user_id OR user_id = :pal_id',
            array(
                ':user_id' => $this->_user_id,
                ':pal_id' => $pal_id,
            ))
            ->queryAll();

        foreach($dialogs as $dialog1){
            foreach($dialogs as $dialog2)
                if ($dialog1['user_id'] == $this->_user_id && $dialog2['user_id'] == $pal_id
                    && $dialog1['dialog_id'] == $dialog2['dialog_id'])
                    return $dialog1['dialog_id'];

        }

        return null;
    }

    /**
     * @return DialogUser[]
     */
    public function getUsersWithNewMessages()
    {
        $dialogUsers = $this->getDialogUsers();

        $result = array();
        foreach ($dialogUsers as $dialogUser) {
            $dialog = $dialogUser->dialog;

            if ($dialogUser->user_id == $this->_user_id)
            continue;

            if (!isset($dialog->lastMessage))
                continue;

            if ($dialog->lastMessage->user_id != $this->_user_id && $dialog->lastMessage->read_status == 0){
                if (isset($dialog->lastDeleted) && $dialog->lastDeleted->user_id == $this->_user_id
                    && $dialog->lastDeleted->message_id == $dialogUser->dialog->lastMessage->id){}
                else
                    $result[] = $dialogUser;
            }
        }

        return $result;
    }
}
