<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 12/3/12
 * Time: 5:29 PM
 * To change this template use File | Settings | File Templates.
 */
class ActiveUsersWidget extends CWidget
{
    const TYPE_CLUBS = 0;
    const TYPE_BLOGS = 1;

    public $type;

    public function run()
    {
        $month = $this->getByMonth();
        $week = $this->getByWeek();
        $day = $this->getByDay();

        $usersIds = array();
        foreach ($month as $m)
            $usersIds[] = $m['id'];
        foreach ($week as $w)
            $usersIds[] = $w['id'];
        foreach ($day as $d)
            $usersIds[] = $d['id'];
        $usersIds = array_unique($usersIds);

        $criteria = new CDbCriteria(array(
            'with' => array(
                'avatar',
            ),
            'index' => 'id',
        ));
        $criteria->addInCondition('t.id', $usersIds);
        $users = User::model()->findAll($criteria);

        $this->render('index', compact('month', 'week', 'day', 'users'));
    }

    protected function getByMonth()
    {
        $sql = "
            SELECT id, cCount, cmCount, (cCount * 10 + cmCount) AS rating FROM
            (
                SELECT users.id, (
                    SELECT COUNT(*)
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    WHERE author_id = users.id AND :column IS NOT NULL AND YEAR(created) = YEAR(CURDATE()) AND MONTH(created) = MONTH(CURDATE()) AND author_id != :happy_giraffe
                ) AS cCount, (
                    SELECT COUNT(*)
                    FROM comments
                    WHERE entity = :entity AND author_id = users.id AND YEAR(created) = YEAR(CURDATE()) AND MONTH(created) = MONTH(CURDATE()) AND author_id != :happy_giraffe
                ) AS cmCount
                FROM users
            ) AS counts
            ORDER BY rating DESC
            LIMIT 10;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':happy_giraffe', User::HAPPY_GIRAFFE);
        if ($this->type == self::TYPE_CLUBS) {
            $command->bindValue(':column', 'r.community_id');
            $command->bindValue(':entity', 'CommunityContent');
        } else {
            $command->bindValue(':column', 'r.user_id');
            $command->bindValue(':entity', 'BlogContent');
        }
        return $command->queryAll();
    }

    protected function getByWeek()
    {
        $sql = "
            SELECT id, cCount, cmCount, (cCount * 10 + cmCount) AS rating FROM
            (
                SELECT users.id, (
                    SELECT COUNT(*)
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    WHERE author_id = users.id AND :column IS NOT NULL AND YEAR(created) = YEAR(CURDATE()) AND WEEK(created, 5) = WEEK(CURDATE(), 5) AND author_id != :happy_giraffe
                ) AS cCount, (
                    SELECT COUNT(*)
                    FROM comments
                    WHERE entity = :entity AND author_id = users.id AND YEAR(created) = YEAR(CURDATE()) AND WEEK(created, 5) = WEEK(CURDATE(), 5) AND author_id != :happy_giraffe
                ) AS cmCount
                FROM users
            ) AS counts
            ORDER BY rating DESC
            LIMIT 10;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':happy_giraffe', User::HAPPY_GIRAFFE);
        if ($this->type == self::TYPE_CLUBS) {
            $command->bindValue(':column', 'r.community_id');
            $command->bindValue(':entity', 'CommunityContent');
        } else {
            $command->bindValue(':column', 'r.user_id');
            $command->bindValue(':entity', 'BlogContent');
        }
        return $command->queryAll();
    }

    protected function getByDay()
    {
        $sql = "
            SELECT id, cCount, cmCount, (cCount * 10 + cmCount) AS rating FROM
            (
                SELECT users.id, (
                    SELECT COUNT(*)
                    FROM community__contents c
                    JOIN community__rubrics r ON c.rubric_id = r.id
                    WHERE author_id = users.id AND :column IS NOT NULL AND YEAR(created) = YEAR(CURDATE()) AND MONTH(created) = MONTH(CURDATE()) AND DAY(created) = DAY(CURDATE()) AND author_id != :happy_giraffe
                ) AS cCount, (
                    SELECT COUNT(*)
                    FROM comments
                    WHERE entity = :entity AND author_id = users.id AND YEAR(created) = YEAR(CURDATE()) AND MONTH(created) = MONTH(CURDATE()) AND DAY(created) = DAY(CURDATE()) AND author_id != :happy_giraffe
                ) AS cmCount
                FROM users
            ) AS counts
            ORDER BY rating DESC
            LIMIT 10;
        ";

        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':happy_giraffe', User::HAPPY_GIRAFFE);
        if ($this->type == self::TYPE_CLUBS) {
            $command->bindValue(':column', 'r.community_id');
            $command->bindValue(':entity', 'CommunityContent');
        } else {
            $command->bindValue(':column', 'r.user_id');
            $command->bindValue(':entity', 'BlogContent');
        }
        return $command->queryAll();
    }
}
