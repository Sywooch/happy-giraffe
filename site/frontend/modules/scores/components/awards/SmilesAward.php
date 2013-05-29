<?php
/**
 * Author: alexk984
 * Date: 28.09.12
 *
 * Мисс/Мистер Улыбка
 */
class SmilesAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $award_id = 24;

        $criteria = self::getSimpleCriteria();

        $models = array(1);
        $users = array();
        $i = 0;
        while (!empty($models)) {
            $criteria->offset = 100 * $i;
            $models = CommunityContent::model()->findAll($criteria);

            foreach ($models as $model) {

                if (!empty($model->postContent) && !empty($model->author_id))
                    $users = self::findSmiles($users, $model->postContent->text, $model->author_id);
                if (!empty($model->videoContent) && !empty($model->author_id))
                    $users = self::findSmiles($users, $model->videoContent->text, $model->author_id);

                foreach ($model->comments as $comment) {
                    if (empty($comment->removed) && !empty($comment->author_id))
                        $users = self::findSmiles($users, $comment->text, $comment->author_id);
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
            if ($count == $max)
                self::giveAward($user, $award_id);
    }

    public function getSimpleCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('t.id', 't.author_id');
        $criteria->scopes = array('active');
        $criteria = self::addMonthCriteria($criteria);
        $criteria->limit = 100;
        $criteria->condition .= ' AND t.author_id != 1';
        $criteria->with = array(
            'comments' => array('select' => 'text', 'author_id', 'removed'),
            'postContent' => array('select' => 'text'),
            'videoContent' => array('select' => 'text'),
        );

        return $criteria;
    }

    public static function findSmiles($users, $text, $user_id)
    {
        $count = substr_count($text, 'src="/images/widget/smiles/');

        return self::addUser($users, $user_id, $count);
    }

    public static function addUser($users, $user_id, $count)
    {
        if (!isset($users[$user_id]))
            $users[$user_id] = 0;
        $users[$user_id] += $count;

        return $users;
    }
}
