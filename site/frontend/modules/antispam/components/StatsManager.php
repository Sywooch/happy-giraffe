<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 06/02/14
 * Time: 16:25
 * To change this template use File | Settings | File Templates.
 */

class StatsManager
{
    public static function getLast2WeeksCounts()
    {
        $end = new DateTime();
        $start = new DateTime();
        $start->modify('-2 week');
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        $sql = "
            SELECT DATE(p.created) AS date, COUNT(*) AS count
            FROM community__contents p
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = p.author_id
            WHERE p.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.user_id IS NOT NULL AND p.created < NOW()
            GROUP BY YEAR(p.created), MONTH(p.created), DAY(p.created);
        ";
        $blogPosts = self::getAssociativeArray($sql);

        $sql = "
            SELECT DATE(p.created) AS date, COUNT(*) AS count
            FROM community__contents p
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = p.author_id
            WHERE p.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.community_id IS NOT NULL AND p.created < NOW()
            GROUP BY YEAR(p.created), MONTH(p.created), DAY(p.created);
        ";
        $communityPosts = self::getAssociativeArray($sql);

        $sql = "
            SELECT DATE(c.created) AS date, COUNT(*) AS count
            FROM comments c
            JOIN community__contents p ON c.entity_id = p.id AND (c.entity = 'BlogContent' OR c.entity = 'CommunityContent')
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = c.author_id
            WHERE c.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.user_id IS NOT NULL
            GROUP BY YEAR(c.created), MONTH(c.created), DAY(c.created);
        ";
        $blogComments = self::getAssociativeArray($sql);

        $sql = "
            SELECT DATE(c.created) AS date, COUNT(*) AS count
            FROM comments c
            JOIN community__contents p ON c.entity_id = p.id AND (c.entity = 'BlogContent' OR c.entity = 'CommunityContent')
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = c.author_id
            WHERE c.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.community_id IS NOT NULL
            GROUP BY YEAR(c.created), MONTH(c.created), DAY(c.created);
        ";
        $communityComments = self::getAssociativeArray($sql);

        $result = array();
        foreach ($period as $date)
            $result[] = array(
                $date->format('d.m.Y'),
                self::getValue($blogPosts, $date->format('Y-m-d')),
                self::getValue($communityPosts, $date->format('Y-m-d')),
                self::getValue($blogComments, $date->format('Y-m-d')),
                self::getValue($communityComments, $date->format('Y-m-d')),
            );

        return $result;
    }

    public static function getLast2DaysCount()
    {
        $end = new DateTime();
        $start = new DateTime();
        $start->modify('-2 day');
        $period = new DatePeriod($start, new DateInterval('PT1H'), $end);

        $sql = "
            SELECT CONCAT(DATE(p.created), ' ', HOUR(p.created), ':00:00') AS date, COUNT(*) AS count
            FROM community__contents p
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = p.author_id
            WHERE p.created > DATE_SUB(CURDATE(), INTERVAL 2 DAY) AND u.group = 0 AND r.user_id IS NOT NULL AND p.created < NOW()
            GROUP BY YEAR(p.created), MONTH(p.created), DAY(p.created), HOUR(p.created);
        ";
        $blogPosts = self::getAssociativeArray($sql);

        $sql = "
            SELECT CONCAT(DATE(p.created), ' ', HOUR(p.created), ':00:00') AS date, COUNT(*) AS count
            FROM community__contents p
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = p.author_id
            WHERE p.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.community_id IS NOT NULL AND p.created < NOW()
            GROUP BY YEAR(p.created), MONTH(p.created), DAY(p.created), HOUR(p.created);
        ";
        $communityPosts = self::getAssociativeArray($sql);

        $sql = "
            SELECT CONCAT(DATE(c.created), ' ', HOUR(c.created), ':00:00') AS date, COUNT(*) AS count
            FROM comments c
            JOIN community__contents p ON c.entity_id = p.id AND (c.entity = 'BlogContent' OR c.entity = 'CommunityContent')
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = c.author_id
            WHERE c.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.user_id IS NOT NULL
            GROUP BY YEAR(c.created), MONTH(c.created), DAY(c.created), HOUR(c.created);
        ";
        $blogComments = self::getAssociativeArray($sql);

        $sql = "
            SELECT CONCAT(DATE(c.created), ' ', HOUR(c.created), ':00:00') AS date, COUNT(*) AS count
            FROM comments c
            JOIN community__contents p ON c.entity_id = p.id AND (c.entity = 'BlogContent' OR c.entity = 'CommunityContent')
            JOIN community__rubrics r ON r.id = p.rubric_id
            JOIN users u ON u.id = c.author_id
            WHERE c.created > DATE_SUB(CURDATE(), INTERVAL 2 WEEK) AND u.group = 0 AND r.community_id IS NOT NULL
            GROUP BY YEAR(c.created), MONTH(c.created), DAY(c.created), HOUR(c.created);
        ";
        $communityComments = self::getAssociativeArray($sql);

        $result = array();
        foreach ($period as $date)
            $result[] = array(
                $date->format('d.m.Y H:00:00'),
                self::getValue($blogPosts, $date->format('Y-m-d H:00:00')),
                self::getValue($communityPosts, $date->format('Y-m-d H:00:00')),
                self::getValue($blogComments, $date->format('Y-m-d H:00:00')),
                self::getValue($communityComments, $date->format('Y-m-d H:00:00')),
            );

        return $result;
    }

    protected function getAssociativeArray($sql)
    {
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $result = array();
        foreach ($rows as $r)
            $result[$r['date']] = $r['count'];
        return $result;
    }

    protected function getValue(&$array, $key)
    {
        return isset($array[$key]) ? $array[$key] : 0;
    }
}