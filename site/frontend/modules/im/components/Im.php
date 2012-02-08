<?php

/**
 * Store in cache user dialogs with opponents
 */
class Im
{
    protected static $instance;
    private $_dialog_users;
    private $_dialogs;
    const USER_CACHE_ID = 'user_dialogs_';
    private $_user_id;

    private function __construct()
    {
        $this->_user_id = Yii::app()->user->getId();
        $this->loadDialogs();
    }

    private function loadDialogs()
    {
        $value = Yii::app()->cache->get(self::USER_CACHE_ID . $this->_user_id);
        if ($value === false || $value === null) {
            $this->refreshDialogUsers();
        } else {
            $this->_dialog_users = $value['users'];
            if (!is_array($value['dialogs']))
                $value['dialogs'] = array();
            else
                $this->_dialogs = $value['dialogs'];
        }
    }

    public function refreshDialogUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.id IN (SELECT dialog_id FROM message_user WHERE user_id = ' . $this->_user_id . ')';
        $dialogs = MessageDialog::model()->with(array(
            'messageUsers', 'lastMessage', 'lastDeletedMessage'
        ))->findAll($criteria);
        $users = array();
        $this->_dialogs = array();
        foreach ($dialogs as $dialog) {
            $new_dialog = array(
                'id' => $dialog->id,
                'name' => '',
                'users' => array(),
                'empty'=>false
            );

            //check empty dialogs
            if (empty($dialog->lastMessage))
                $new_dialog['empty']=true;

            if (isset($dialog->lastMessage) && isset($dialog->lastDeletedMessage))
                if ($dialog->lastMessage->id <= $dialog->lastDeletedMessage->message_id)
                    $new_dialog['empty']=true;

            foreach ($dialog->messageUsers as $user) {
                if ($user->user_id !== $this->_user_id && !in_array($user->user_id, $this->_dialogs)) {
                    $users [] = $user->user_id;
                    $new_dialog['name'] = User::getUserById($user->user_id)->getFullName();
                    $new_dialog['users'][] = $user->user_id;
                }
            }
            $this->_dialogs[$dialog->id] = $new_dialog;
        }

        $this->_dialog_users = $users;
        Yii::app()->cache->set(self::USER_CACHE_ID . $this->_user_id, array(
            'users' => $users,
            'dialogs' => $this->_dialogs
        ));
    }

    /**
     * @return array
     */
    public function getDialogIds()
    {
        $res = array();
        foreach ($this->_dialogs as $dialog)
            $res [] = $dialog['id'];
        return $res;
    }

    /**
     * @return array
     */
    public function getNotEmptyDialogIds()
    {
        $res = array();
        foreach ($this->_dialogs as $dialog)
            if (!$dialog['empty'])
                $res [] = $dialog['id'];
        return $res;
    }

    /**
     * @static
     * @return Im
     */
    public static function model()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Im;
        }
        return self::$instance;
    }

    /**
     * @param $term
     * @return array
     */
    public function findDialogUserNames($term)
    {
        $result = array();
        foreach ($this->_dialog_users as $user_id) {
            $user = User::getUserById($user_id);
            if ($this->startsWith($user->first_name, $term) || $this->startsWith($user->last_name, $term)
                || $this->startsWith($user->first_name . ' ' . $user->last_name, $term)
                || $this->startsWith($user->last_name . ' ' . $user->first_name, $term)
            ) {
                $result[] = $user->getFullName();
            }
        }

        return $result;
    }

    /**
     * @param $dialog_id
     * @return User
     */
    public function GetDialogUser($dialog_id)
    {
        $id = $this->_dialogs[$dialog_id]['users'][0];
        return User::getUserById($id);
    }

    /**
     * @param $user_id
     * @return mixed
     */
    public function getDialogByUser($user_id)
    {
        foreach ($this->_dialogs as $dialog) {
            if ($dialog['users'][0] == $user_id) {
                return $dialog['id'];
            }
        }
        return null;
    }

    public function findDialog($name)
    {
        foreach ($this->_dialogs as $dialog) {
            if ($dialog['name'] == $name) {
                return $dialog['id'];
            }
        }

        return null;
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    static function clearCache()
    {
        Yii::app()->cache->delete(self::USER_CACHE_ID . Yii::app()->user->getId());
    }
}
