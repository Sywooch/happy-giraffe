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
    const WHATS_NEW_ALL = 0;
    const WHATS_NEW_CLUBS = 1;
    const WHATS_NEW_CLUBS_MY = 2;
    const WHATS_NEW_BLOGS = 3;
    const WHATS_NEW_BLOGS_MY = 4;

    public static function getIndex($limit)
    {
        return self::getDataProvider(self::WHATS_NEW_ALL, $limit);
    }

    public static function getClubs($limit, $show)
    {
        return self::getDataProvider(($show == 'my') ? self::WHATS_NEW_CLUBS_MY : self::WHATS_NEW_CLUBS, $limit);
    }

    public static function getBlogs($limit, $show)
    {
        return self::getDataProvider(($show == 'my') ? self::WHATS_NEW_BLOGS_MY : self::WHATS_NEW_BLOGS, $limit);
    }

//    public static function getDataProvider($type, $limit)
//    {
//        $rows = self::getRowsByType($type, $limit);
//
//        $events = array();
//        foreach ($rows as $r) {
//            $event = Event::factory($r['type']);
//            $event->attributes = $r;
//            $events[] = $event;
//        }
//
//        return new CArrayDataProvider($events, array(
//            'pagination' => array(
//                'pageSize' => 20,
//            )
//        ));
//    }

    public static function getDataProvider($type, $limit)
    {
        switch ($type) {
            case self::WHATS_NEW_ALL:
                $sql = '
                    (SELECT c.id, last_updated, 0 AS type FROM community__contents c JOIN community__rubrics r ON c.rubric_id = r.id WHERE last_updated IS NOT NULL AND removed = 0 AND rubric_id IS NOT NULL AND (r.community_id != 36 OR r.community_id IS NULL))
                    UNION
                    (SELECT id, last_updated, 1 AS type FROM contest__contests WHERE last_updated IS NOT NULL)
                    UNION
                    (SELECT id, created AS last_updated, 2 AS type FROM cook__decorations ORDER BY id DESC LIMIT 1)
                    UNION
                    (SELECT id, last_updated, 3 AS type FROM cook__recipes WHERE last_updated IS NOT NULL)
                    UNION
                    (SELECT id, register_date AS last_updated, 4 AS type FROM users WHERE deleted = 0 ORDER BY id DESC LIMIT 1)
                ';
                $params = array();
                break;
            case self::WHATS_NEW_CLUBS:
                $sql = '
                    SELECT c.id, last_updated, 0 AS type
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    WHERE last_updated IS NOT NULL AND r.community_id IS NOT NULL AND removed = 0 AND rubric_id IS NOT NULL AND (r.community_id != 36 OR r.community_id IS NULL)
                ';
                $params = array();
                break;
            case self::WHATS_NEW_CLUBS_MY:
                $sql = '
                    SELECT c.id, last_updated, 0 AS type
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    JOIN user__users_communities uc ON r.community_id = uc.community_id AND uc.user_id = :user_id
                    WHERE last_updated IS NOT NULL AND r.community_id IS NOT NULL AND removed = 0 AND rubric_id IS NOT NULL AND (r.community_id != 36 OR r.community_id IS NULL)
                ';
                $params = array(':user_id' => Yii::app()->user->id);
                break;
            case self::WHATS_NEW_BLOGS:
                $sql = '
                    SELECT c.id, last_updated, 0 AS type
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    WHERE last_updated IS NOT NULL AND r.user_id IS NOT NULL AND removed = 0 AND rubric_id IS NOT NULL
                ';
                $params = array();
                break;
            case self::WHATS_NEW_BLOGS_MY:
                $sql = '
                    SELECT c.id, last_updated, 0 AS type
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    JOIN friends f ON (f.user1_id = r.user_id AND f.user2_id = :user_id) OR (f.user2_id = r.user_id AND f.user1_id = :user_id)
                    WHERE last_updated IS NOT NULL AND r.user_id IS NOT NULL AND removed = 0 AND rubric_id IS NOT NULL
                ';
                $params = array(':user_id' => Yii::app()->user->id);
                break;
        }

        return new EventDataProvider($sql, array(
            'params' => $params,
            'pagination' => array(
                'pageSize' => 20,
            ),
            'sort' => array(
                'defaultOrder' => 'last_updated DESC',
            ),
            'totalItemCount' => 100,
        ));
    }
}
