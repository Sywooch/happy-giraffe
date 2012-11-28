<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 11/28/12
 * Time: 12:16 PM
 * To change this template use File | Settings | File Templates.
 */
class EventManager
{
    public function getLive()
    {

    }

    public function getClubs($all)
    {

    }

    public function getBlogs($all)
    {

    }

    public function getPostsQuery($from, $all)
    {
        $command = Yii::app()->db->createCommand();
        $command
            ->select('id, last_updated, 0 AS type')
            ->from('community__contents')
            ->where('last_updated IS NOT NULL')
        :

    }
}
