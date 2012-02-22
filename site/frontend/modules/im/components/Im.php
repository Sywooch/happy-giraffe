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
    private $_loaded_users = array();

    private function __construct($user_id = null)
    {
        if ($user_id === null)
            $this->_user_id = Yii::app()->user->getId();
        else
            $this->_user_id = $user_id;

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
                'empty' => false
            );

            //check empty dialogs
            if (empty($dialog->lastMessage))
                $new_dialog['empty'] = true;

            if (isset($dialog->lastMessage) && isset($dialog->lastDeletedMessage))
                if ($dialog->lastMessage->id <= $dialog->lastDeletedMessage->message_id)
                    $new_dialog['empty'] = true;

            foreach ($dialog->messageUsers as $user) {
                if ($user->user_id !== $this->_user_id && !in_array($user->user_id, $this->_dialogs)) {
                    $um = $this->getUser($user->user_id);
                    if ($um === null){

                        continue;
                    }
                    $users [] = $user->user_id;
                    $new_dialog['name'] = $this->getUser($user->user_id)->getFullName();
                    $new_dialog['users'][] = $user->user_id;
                }
            }
            if (empty($new_dialog['users'])){
                //remove dialog
                MessageDialog::model()->deleteByPk($dialog->id);
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

    public function getDialog($id)
    {
        foreach ($this->_dialogs as $dialog)
            if ($id == $dialog['id'])
                return array(
                    'id'=>$id,
                    'user'=>$this->GetDialogUser($id)
                );
        return null;
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
     * @param null $user_id
     * @return Im
     */
    public static function model($user_id = null)
    {
        if (is_null(self::$instance)) {
            self::$instance = new Im($user_id);
        }
        return self::$instance;
    }

    /**
     * @param $term
     * @return array
     */
    public function findDialogUserNames($term)
    {
        $term = strtolower($term);
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

        return $result;
    }

    /**
     * @param $dialog_id
     * @return User
     */
    public function GetDialogUser($dialog_id)
    {
//        if (!isset($this->_dialogs[$dialog_id]))
//        {var_dump($dialog_id);Yii::app()->end();}
        $id = $this->_dialogs[$dialog_id]['users'][0];
        return $this->getUser($id);
    }

    /**
     * @param $user_id
     * @return int
     */
    public function getDialogByUser($user_id)
    {
        foreach ($this->_dialogs as $dialog) {
            if (!isset($dialog['users'][0]))
                return null;
            if ($dialog['users'][0] == $user_id) {
                return $dialog['id'];
            }
        }
        return null;
    }

    public function findDialog($name)
    {
        foreach ($this->_dialogs as $dialog) {
            $pal_id = $dialog['users'][0];
            if (mb_strtolower($this->getUser($pal_id)->getFullName(), 'utf-8') == mb_strtolower($name, 'utf-8')) {
                return $dialog['id'];
            }
        }

        return null;
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        $haystack = mb_strtolower($haystack, 'utf-8');
        return (substr($haystack, 0, $length) === $needle);
    }

    public function getDialogs()
    {
        return $this->_dialogs;
    }

    static function clearCache($user_id = null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->getId();
        Yii::app()->cache->delete(self::USER_CACHE_ID . $user_id);
    }

    /**
     * @param $id
     * @return User
     */
    public function getUser($id)
    {
        if (!empty($this->_loaded_users[$id]))
            return $this->_loaded_users[$id];
        $user = User::getUserById($id);
        if ($user === null)
            return null;

        $this->_loaded_users[$id] = $user;
        return $user;
    }

    public static function getUnreadMessagesCount($user_id)
    {
        Yii::import('site.frontend.modules.im.models.*');

        $criteria = new CDbCriteria;
        $criteria->condition = 't.id IN (SELECT dialog_id FROM message_user WHERE user_id = ' . $user_id . ')';
        $criteria->select = 'id';
        $dialogs = MessageDialog::model()->findAll($criteria);

        $unread = 0;
        foreach ($dialogs as $dialog) {
            $unread += MessageDialog::getUnreadMessagesCount($dialog->id, $user_id);
        }

        return $unread;
    }
}
