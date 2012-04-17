<?php

/**
 * Store in cache user dialogs with opponents
 */
class Im
{
    const USER_CACHE_ID = 'user_dialogs_';
    /*
     * Instance for each user
     */
    protected static $instances = array();

    /**
     * @var int[] all user's interlocutors
     */
    private $_dialog_users;
    /**
     * @var array All user dialogs array('id','name','users' => array())
     */
    private $_dialogs;
    /**
     * @var int|null user for whom we create this instance
     */
    private $_user_id;
    /**
     * @var array users loaded from cache can not be loaded again
     */
    private $_loaded_users = array();

    /**
     * @param null|int $user_id
     */
    private function __construct($user_id = null)
    {
        if ($user_id === null)
            $this->_user_id = Yii::app()->user->id;
        else
            $this->_user_id = $user_id;

        $this->loadDialogs();
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
     * Load all user dialogs with its users from cache
     */
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

    /**
     * Refresh all user dialogs with its users
     */
    public function refreshDialogUsers()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 't.id IN (SELECT dialog_id FROM im__dialog_users WHERE user_id = ' . $this->_user_id . ')';
        $dialogs = Dialog::model()->with(array(
            'dialogUsers'
        ))->findAll($criteria);

        $users = array();
        $this->_dialogs = array();

        foreach ($dialogs as $dialog) {
            $new_dialog = array(
                'id' => $dialog->id,
                'name' => '',
                'users' => array(),
            );

            foreach ($dialog->dialogUsers as $user) {
                if ($user->user_id !== $this->_user_id) {
                    $users [] = $user->user_id;
                    $new_dialog['name'] = $this->getUser($user->user_id)->getFullName();
                    $new_dialog['users'][] = $user->user_id;
                }
            }
            if (empty($new_dialog['users'])){
                //remove dialog where no users
                Dialog::model()->deleteByPk($dialog->id);
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
     * All dialog id's
     *
     * @return int[]
     */
    public function getDialogIds()
    {
        $res = array();
        foreach ($this->_dialogs as $dialog)
            $res [] = $dialog['id'];
        return $res;
    }

    public function getDialogsCount()
    {
        return count($this->_dialogs);
    }

    /**
     * @param $id
     * @return array ('id', 'user')
     */
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

    /*public function getNotEmptyDialogIds()
    {
        $res = array();
        foreach ($this->_dialogs as $dialog)
            if (!$dialog['empty'])
                $res [] = $dialog['id'];
        return $res;
    }*/

    /**
     * Search users from dialogs
     *
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
     * Get User model of dialog interlocutor
     *
     * @param $dialog_id
     * @return User
     */
    public function GetDialogUser($dialog_id)
    {
        if (!isset($this->_dialogs[$dialog_id]['users'][0]))
            return null;
        $id = $this->_dialogs[$dialog_id]['users'][0];
        return $this->getUser($id);
    }

    /**
     * @param $user_id
     * @return int
     */
    public function getDialogIdByUser($user_id)
    {
        foreach ($this->_dialogs as $dialog) {
            if ($dialog['users'][0] == $user_id) {
                return $dialog['id'];
            }
        }
        return null;
    }

    /**
     * Find dialog by interlocutor's name
     * @param $name
     * @return null|int
     */
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

    /**
     * @return array ('id','name','users' => array())
     */
    public function getDialogs()
    {
        return $this->_dialogs;
    }

    static function clearCache($user_id = null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->id;
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
        $criteria = new CDbCriteria;
        $criteria->condition = 't.id IN (SELECT dialog_id FROM im__dialog_users WHERE user_id = ' . $user_id . ')';
        $criteria->select = 'id';
        $dialogs = Dialog::model()->findAll($criteria);

        $unread = 0;
        foreach ($dialogs as $dialog) {
            $unread += Dialog::getUnreadMessagesCount($dialog->id, $user_id);
        }

        return $unread;
    }
}
