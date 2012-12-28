<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/7/12
 * Time: 12:19 PM
 * To change this template use File | Settings | File Templates.
 */
class FriendEventManager
{
    public static function add($type, $params)
    {
        $model = FriendEvent::model($type);
        $model->isNewRecord = true;
        $model->params = $params;
        $stack = $model->getStack();
        if ($stack === null)
            $model->createBlock();
        else
            $stack->updateBlock($model);
    }

    public static function getDataProvider($user, $limit = 20)
    {
        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'user_id' => array('in' => self::getUserFriendIds($user)),
            ),
        ));

        $criteria->sort('updated', EMongoCriteria::SORT_DESC);

        return new FriendEventDataProvider('FriendEvent', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $limit),
        ));
    }

    public static function getUserFriendIds($user)
    {
        $cache_id = 'user_friends_ids_'.$user->id;
        $value=Yii::app()->cache->get($cache_id);
        if($value===false)
        {
            $friends = User::model()->cache(60)->findAll($user->getFriendsCriteria(array('select' => 't.id', 'index' => 'id')));
            $value = array_keys($friends);
            Yii::app()->cache->set($cache_id,$value, 60);
        }

        return $value;
    }

    public static function getUserEventDataProvider($user_id, $limit = 20)
    {
        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'user_id' => array('==' => (int)$user_id),
            ),
        ));

        $criteria->sort('updated', EMongoCriteria::SORT_DESC);

        return new FriendEventDataProvider('FriendEvent', array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => $limit),
        ));
    }

    public function getBlockId()
    {
        return md5($this->seed);
    }
}
