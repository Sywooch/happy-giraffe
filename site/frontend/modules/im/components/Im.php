<?php

class Im
{
    protected static $instance;
    private $_dialog_users;
    private $_dialogs;
    private $_users_cache_id = 'user_dialogs_';
    private $_user_id;

    private function __construct()
    {
        $this->_user_id = Yii::app()->user->getId();
        $this->loadDialogs();
    }

    private function loadDialogs()
    {
        $value = Yii::app()->cache->get($this->_users_cache_id . $this->_user_id);
        if ($value === false || $value === null) {
            $this->refreshDialogUsers();
        } else{
            $this->_dialog_users = $value['users'];
            $this->_dialogs = $value['dialogs'];
        }
    }

    public function refreshDialogUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.id IN (SELECT dialog_id FROM message_user WHERE user_id = ' . $this->_user_id . ')';
        $dialogs = MessageDialog::model()->with(array(
            'messageUsers',
            array('messageUsers.user' => array(
                'select' => array('id', 'first_name', 'last_name')
            ))
        ))->findAll($criteria);

        $value = array();
        $users = array();
        foreach ($dialogs as $dialog) {
            $new_dialog = array(
                'id' => $dialog->id,
                'name' => '',
                'users' => array()
            );
            foreach ($dialog->messageUsers as $user) {
                if ($user->user_id !== $this->_user_id && !in_array($user->user_id, $value)) {
                    $users [] = $user->user_id;
                    $new_dialog['name'] = $user->user->getFullName();
                    $new_dialog['users'][] = $user->user_id;
                }
            }
            $value[$dialog->id] = $new_dialog;
        }

        $this->_dialog_users = $users;
        $this->_dialogs = $value;
        Yii::app()->cache->set($this->_users_cache_id . $this->_user_id, array(
            'users' => $users,
            'dialogs' => $value
        ));
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
            $user = User::model()->findByPk($user_id);
            if ($this->startsWith($user->first_name, $term) || $this->startsWith($user->last_name, $term)
                || $this->startsWith($user->first_name . ' ' . $user->last_name, $term)
                || $this->startsWith($user->last_name . ' ' . $user->first_name, $term)
            ) {
                $result[] = $user->getFullName();
            }
        }

        return $result;
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

    static public function clearCache()
    {
        Yii::app()->cache->delete($this->_users_cache_id . Yii::app()->user->getId());
    }
}
