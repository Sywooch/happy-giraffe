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
            $stack->update($model);
    }
}
