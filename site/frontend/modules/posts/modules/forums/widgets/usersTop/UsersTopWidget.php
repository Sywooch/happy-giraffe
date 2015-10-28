<?php
namespace site\frontend\modules\posts\modules\forums\widgets\usersTop;
use site\frontend\components\api\models\User;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\models\Tag;

/**
 * @author Никита
 * @date 27/10/15
 */

class UsersTopWidget extends \CWidget
{
    const POSTS_MULTIPLIER = 5;
    const COMMENTS_MULTIPLIER = 1;
    const CACHE_DURATION = 300;

    public function run()
    {
        $scores = $this->getScores();
        $users = User::model()->findAllByPk(array_keys($scores));
        $this->render('view', compact('scores', 'users'));
    }

    protected function getScores()
    {
        $cacheId = $this->getCacheId();
        $value = \Yii::app()->cache->get($cacheId);
        if ($value === false) {
            $criteria = clone Content::model()->byLabels(array('Buzz'))->getDbCriteria();
            $criteria->join = 'JOIN ' . Tag::model()->tableName() . ' tagModels ON tagModels.contentId = t.id';
            $command = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria);
            $ids = $command->queryColumn();

            $criteria2 = new \CDbCriteria();
            $criteria2->addInCondition('t.id', $ids);
            $criteria2->group = 'authorId';
            $criteria2->select = 'authorId AS uId, COUNT(*) AS n';
            $command2 = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria2);
            $posts = $command2->queryAll();

            $criteria2 = new \CDbCriteria();
            $criteria2->addInCondition('t.id', $ids);
            $criteria2->group = 'author_id';
            $criteria2->select = 'author_id AS uId, COUNT(*) AS n';
            $command2 = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria2);
            $comments = $command2->queryAll();

            $scores = array();
            $this->process($posts, $scores, self::POSTS_MULTIPLIER);
            $this->process($comments, $scores, self::COMMENTS_MULTIPLIER);
            arsort($scores);
            $value = $scores;

            \Yii::app()->cache->set($cacheId, $value, 300);
        }
        return $value;
    }

    protected function getCacheId()
    {
        return get_class() . '.scores';
    }

    protected function process($input, &$output, $multiplier = 1)
    {
        foreach ($input as $p) {
            if (! isset($output[$p['uId']])) {
                $output[$p['uId']] = 0;
            }

            $output[$p['uId']] += $p['n'] * $multiplier;
        }
    }
}