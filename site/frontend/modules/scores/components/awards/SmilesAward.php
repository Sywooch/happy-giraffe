<?php
/**
 * Class SmilesAward
 *
 * Мисс/Мистер Улыбка
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class SmilesAward extends CAward
{
    public static function execute()
    {
        echo "\n" . get_class() . "\n";

        $award_id = ScoreAward::TYPE_SMILE;

        $criteria = self::getSimpleCriteria();

        $models = array(1);
        $users = array();
        $i = 0;
        while (!empty($models)) {
            $criteria->offset = 100 * $i;
            $models = CommunityContent::model()->findAll($criteria);

            foreach ($models as $model) {

                if (!empty($model->post) && !empty($model->author_id))
                    $users = self::findSmiles($users, $model->post->text, $model->author_id);
                if (!empty($model->video) && !empty($model->author_id))
                    $users = self::findSmiles($users, $model->video->text, $model->author_id);

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

    /**
     * Критей выбора всех статей за месяц
     *
     * @return CDbCriteria
     */
    public function getSimpleCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->select = array('t.id', 't.author_id');
        $criteria->scopes = array('active');
        $criteria->addCondition(self::getTimeCondition());
        $criteria->limit = 100;
        $criteria->condition .= ' AND t.author_id != 1';
        $criteria->with = array(
            'comments' => array('select' => 'text', 'author_id', 'removed'),
            'post' => array('select' => 'text'),
            'video' => array('select' => 'text'),
        );

        return $criteria;
    }

    /**
     * Найти кол-во смайлов в текстах статей
     *
     * @param $users
     * @param $text
     * @param $user_id
     * @return mixed
     */
    public static function findSmiles($users, $text, $user_id)
    {
        $count = substr_count($text, 'src="/images/widget/smiles/');

        return self::addUser($users, $user_id, $count);
    }

    /**
     * Увеличить кол-во смайлов пользователя
     *
     * @param $users int[]
     * @param $user_id int
     * @param $count
     * @return mixed
     */
    public static function addUser($users, $user_id, $count)
    {
        if (!isset($users[$user_id]))
            $users[$user_id] = 0;
        $users[$user_id] += $count;

        return $users;
    }
}
