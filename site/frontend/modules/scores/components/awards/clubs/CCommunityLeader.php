<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 */
abstract class CCommunityLeader extends CAward
{
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
                $users = self::addUser($users, $model->author_id);

                foreach ($model->comments as $comment) {
                    if (empty($comment->removed))
                        $users = self::addUser($users, $comment->author_id);
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

    public function getSimpleCriteria($community_id)
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('t.id', 't.author_id');
        $criteria->scopes = array('active');
        $criteria = self::addMonthCriteria($criteria);
        $criteria->limit = 100;
        $criteria->with = array(
            'rubric' => array(
                'with' => array(
                    'community' => array(
                        'condition' => is_array($community_id) ?
                            'community.id IN (' . implode(',', $community_id) . ')'
                            :
                            'community.id=' . $community_id
                    )
                )
            ),
            'comments'
        );
        $criteria->together = true;

        return $criteria;
    }

    public static function addUser(&$users, $user_id)
    {
        if (!isset($users[$user_id]))
            $users[$user_id] = 0;
        $users[$user_id]++;

        return $users;
    }
}
