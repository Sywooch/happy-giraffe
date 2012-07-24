<?php
/**
 * Author: choo
 * Date: 24.07.2012
 */
class UserAction extends EMongoDocument
{
    const USER_ACTION_MOOD_CHANGED = 0;
    const USER_ACTION_STATUS_CHANGED = 1;

    public $user_id;
    public $updated;
    public $type;
    public $data;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'user_actions';
    }

    public function add($user_id, $type, $params = array())
    {
        $action = new UserAction;
        $action->user_id = (int) $user_id;
        $action->type = $type;
        $action->updated = time();
        $action->data = $action->getDataByParams($params);
        $action->save();
    }

    public function getDataByParams($params)
    {
        switch ($this->type) {
            default:
            return $params;
        }
    }
}
