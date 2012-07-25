<?php
/**
 * Author: choo
 * Date: 24.07.2012
 */
class UserAction extends EMongoDocument
{
    const USER_ACTION_MOOD_CHANGED = 0;
    const USER_ACTION_STATUS_CHANGED = 1;
    const USER_ACTION_PURPOSE_CHANGED = 2;
    const USER_ACTION_CLUBS_JOINED = 3;
    const USER_ACTION_INTERESTS_ADDED = 4;
    const USER_ACTION_PHOTOS_ADDED = 5;
    const USER_ACTION_COMMUNITY_CONTENT_ADDED = 6;
    const USER_ACTION_FRIENDS_ADDED = 7;
    const USER_ACTION_LEVELUP = 8;
    const USER_ACTION_USED_SERVICES = 9;
    const USER_ACTION_FAMILY_UPDATED = 10;
    const USER_ACTION_ADDRESS_UPDATED = 11;
    const USER_ACTION_COMMENT_ADDED = 12;
    const USER_ACTION_RECIPE_ADDED = 13;
    const USER_ACTION_DUEL = 14;
    const USER_ACTION_BLOG_CONTENT_ADDED = 15;

    private $_stackableActions = array(
        self::USER_ACTION_CLUBS_JOINED,
        self::USER_ACTION_INTERESTS_ADDED,
        self::USER_ACTION_USED_SERVICES,
        self::USER_ACTION_FRIENDS_ADDED,
    );

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
        if (($stack = $this->getStack($type)) !== null) {
            $newData = $stack->getDataByParams($params);
            if (array_search($newData, $stack->data) === FALSE) {
                $stack->updated = time();
                $stack->data[] = $newData;
                $stack->save();
            }
        } else {
            $action = new UserAction;
            $action->user_id = (int) $user_id;
            $action->type = $type;
            $action->updated = time();
            $action->data = (in_array($type, $this->_stackableActions)) ? array($action->getDataByParams($params)) : $action->getDataByParams($params);
            $action->save();
        }
    }

    public function getDataByParams($params)
    {
        switch ($this->type) {
            case self::USER_ACTION_MOOD_CHANGED:
                return $params['model']->getAttributes(array('mood_id'));
                break;
            case self::USER_ACTION_STATUS_CHANGED:
                return $params['model']->getAttributes(array('text', 'created'));
                break;
            case self::USER_ACTION_PURPOSE_CHANGED:
                return $params['model']->getAttributes(array('text'));
                break;
            case self::USER_ACTION_CLUBS_JOINED:
                $community = Community::model()->findByPk($params['community_id']);
                return $community->getAttributes(array('id', 'title'));
                break;
            case self::USER_ACTION_COMMENT_ADDED:
            case self::USER_ACTION_BLOG_CONTENT_ADDED:
            case self::USER_ACTION_COMMUNITY_CONTENT_ADDED:
            case self::USER_ACTION_DUEL:
                return $params['model']->getAttributes(array('id'));
                break;
            default:
                return $params;
        }
    }

    public function getStack($type)
    {
        if (! in_array($type, $this->_stackableActions))
            return null;

        $criteria = new EMongoCriteria();
        $criteria->type = $type;
        $criteria->sort('created', EMongoCriteria::SORT_DESC);
        $stack = self::model()->find($criteria);

        return ($stack !== null && HDate::isSameDate($stack->updated, time())) ? $stack : null;
    }
}
