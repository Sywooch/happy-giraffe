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
        $friends = User::model()->findAll($user->getFriendsCriteria(array('select' => 't.id', 'index' => 'id')));
        $friendsIds = array_keys($friends);

        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'user_id' => array('in' => $friendsIds),
            ),
            'limit'=>$limit
        ));

        $criteria->sort('updated', EMongoCriteria::SORT_DESC);

        return new FriendEventDataProvider('FriendEvent', array(
            'criteria' => $criteria,
        ));
    }

    public function getBlockId()
    {
        return md5($this->seed);
    }
}
