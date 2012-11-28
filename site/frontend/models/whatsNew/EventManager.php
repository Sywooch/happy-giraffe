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
    const FROM_ALL = 0;
    const FROM_CLUBS = 1;
    const FROM_BLOGS = 2;

    public function getLive()
    {

    }

    public function getClubs($all)
    {

    }

    public function getBlogs($all)
    {

    }

    public static function getPostsQuery($from = self::FROM_ALL, $all = true)
    {
        $command = Yii::app()->db->createCommand();

        $command
            ->select(array('id', 'last_updated', new CDbExpression(Event::EVENT_POST . ' AS `type`')))
            ->from('community__contents c')
            ->join('community__rubrics r', 'c.rubric_id = r.id')
        ;

        $conditions = 'last_updated IS NOT NULL AND r.community_id != :news_community';
        if ($from === self::FROM_CLUBS)
            $conditions .= ' AND r.community_id IS NOT NULL';
        elseif ($from === self::FROM_BLOGS)
            $conditions .= ' AND r.user_id IS NOT NULL';

        $command->where($conditions, array(':news_community' => Community::COMMUNITY_NEWS));

        return $command->text;
    }
}
