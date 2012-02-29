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
    private $_lastDialog = null;
    private $_last_dialog_cache_id = 'last_dialog';

    private function __construct()
    {
//        Yii::app()->user->setState($this->_cache_id, array());
        $this->_ids = Yii::app()->user->getState($this->_cache_id);
        $this->_lastDialog = Yii::app()->user->getState($this->_last_dialog_cache_id);
        if (!is_array($this->_ids))
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
     * @return array
     */
    public function getDialogs()
    {
        $dialogs = array();
        foreach($this->_ids as $id){
            $dialogs[] = array(
                'id'=>$id,
                'user'=>Im::model()->GetDialogUser($id)
            );
        }

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
     * @return bool
     */
    public function deleteDialog($id)
    {
        foreach ($this->_ids as $key=>$value) {
            if ($this->_ids[$key] == $id){
                unset($this->_ids[$key]);
                $this->saveDialogs();
                return true;
            }
        }
        return false;
    }

    private function saveDialogs()
    {
        Yii::app()->user->setState($this->_cache_id, $this->_ids);
    }

    /**
     * @return string
     */
    public function GetLastDialogId()
    {
        if (empty($this->_lastDialog))
            return empty($this->_ids)?'':$this->_ids[0];
        return $this->_lastDialog;
    }

    /**
     * @param $id
     */
    public function SetLastDialogId($id){
        $this->_lastDialog = $id;
        Yii::app()->user->setState($this->_last_dialog_cache_id, $id);
    }
}
