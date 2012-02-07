<?php

/**
 * @property int[] $__ids
 * @property ActiveDialogs $instance
 */
class ActiveDialogs
{
    protected static $instance;
    private $_ids;
    private $_cache_id = 'session_dialogs';

    private function __construct()
    {
        $this->_ids = Yii::app()->user->getState($this->_cache_id);
        if ($this->_ids === null)
            $this->_ids = array();
    }

    /**
     * @static
     * @return ActiveDialogs
     */
    public static function model()
    {
        if (is_null(self::$instance)) {
            self::$instance = new ActiveDialogs;
        }
        return self::$instance;
    }

    /**
     * @return int[]
     */
    public function getDialogIds()
    {
        return $this->_ids;
    }

    /**
     * @return MessageDialog[]
     */
    public function getDialogs()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->_ids);
        $dialogs = MessageDialog::model()->with(array(
            'messageUsers','messageUsers.user'
        ))->findAll($criteria);

        return $dialogs;
    }

    /**
     * @param $id
     */
    public function addDialog($id)
    {
        if (!in_array($id, $this->_ids)) {
            $this->_ids[] = $id;
            $this->saveDialogs();
        }
    }

    /**
     * @param $id
     * @return void
     */
    public function deleteDialog($id)
    {
        foreach ($this->_ids as $key=>$value) {
            if ($this->_ids[$key] == $id){
                unset($this->_ids[$key]);
                $this->saveDialogs();
                return ;
            }
        }
    }

    private function saveDialogs()
    {
        Yii::app()->user->setState($this->_cache_id, $this->_ids);
    }
}
