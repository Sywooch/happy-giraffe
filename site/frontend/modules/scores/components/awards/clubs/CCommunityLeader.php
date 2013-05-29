<?php
/**
 * Class CCommunityLeader
 *
 * Награда лидеру сообщества или нескольких сообществ
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
abstract class CCommunityLeader extends CAward
{
    const POST_POINTS = 20;
    const COMMENT_POINTS = 1;

    /**
     * Назначает награды лидерам клуба(клубов)
     *
     * @param $community_id int|int[] id клуба/ов
     * @param $award_id int id награды
     */
    public static function clubLeader($community_id, $award_id)
    {
        $criteria = self::getSimpleCriteria($community_id);

        $models = array(1);
        $users = array();
        $i = 0;
        while (!empty($models)) {
            $criteria->offset = 100 * $i;
            $models = CommunityContent::model()->findAll($criteria);

            foreach ($models as $model) {
                $users = self::addUser($users, $model->author_id, self::POST_POINTS);

                foreach ($model->comments as $comment) {
                    if (empty($comment->removed))
                        $users = self::addUser($users, $comment->author_id, self::COMMENT_POINTS);
                }
            }
            $i++;
        }

        $max = 0;
        foreach ($users as $count)
            if ($count > $max)
                $max = $count;

        echo "max: $max \n";
        foreach ($users as $user => $count)
            if ($count == $max) {
                self::giveAward($user, $award_id);
            }
    }

    /**
     * Возвращает критерий выбора записей в определенных клубах
     *
     * @param $community_id int[] id сообществ
     * @return CDbCriteria
     */
    public function getSimpleCriteria($community_id)
    {
        if (!is_array($community_id))
            $community_id = array($community_id);

        $criteria = new CDbCriteria;
        $criteria->select = array('t.id', 't.author_id');
        $criteria->scopes = array('active');
        $criteria->addCondition(self::getTimeCondition());
        $criteria->limit = 100;
        $criteria->with = array(
            'rubric' => array(
                'with' => array(
                    'community' => array(
                        'condition' => 'community.id IN (' . implode(',', $community_id) . ')'
                    )
                )
            ),
            'comments'
        );
        $criteria->together = true;

        return $criteria;
    }

    /**
     * Добавляет очки пользователю
     *
     * @param int[] $users
     * @param int $user_id id пользователя
     * @param int $points кол-во баллов, которое нужно прибавить
     * @return int[]
     */
    public static function addUser($users, $user_id, $points = 1)
    {
        if (!isset($users[$user_id]))
            $users[$user_id] = 0;
        $users[$user_id] += $points;

        return $users;
    }
}
