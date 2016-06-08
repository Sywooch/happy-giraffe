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
    const LIMIT = 5;

    public function run()
    {
        $scores = $this->getScores();
        $users = User::model()->findAllByPk(array_keys($scores), array('avatarSize' => 40));
        $this->render('view', compact('scores', 'users'));
    }

    protected function getScores()
    {
        $scores = [];
        $this->process($this->getPostsCounts(), $scores, self::POSTS_MULTIPLIER);
        $this->process($this->getCommentsCounts(), $scores, self::COMMENTS_MULTIPLIER);
        arsort($scores);
        return array_slice($scores, 0, self::LIMIT, true);
    }

    protected function process($input, &$output, $multiplier = 1)
    {
        foreach ($input as $row) {
            if (! isset($output[$row['uId']])) {
                $output[$row['uId']] = 0;
            }

            $output[$row['uId']] += $row['c'] * $multiplier;
        }
    }

    protected function getPostsCounts()
    {
        $criteria = $this->getPostsCriteria();
        $criteria->select = 'authorId uId, COUNT(*) c';
        return \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
    }

    protected function getCommentsCounts()
    {
        $criteria = $this->getPostsCriteria();
        $criteria->select = 'comments.author_id uId, COUNT(*) c';
        $criteria->join = 'JOIN comments c ON comments.entity_id = t.originEntityId AND comments.entity = t.originEntity';
        return \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
    }

    /**
     * @return \CDbCriteria
     */
    protected function getPostsCriteria()
    {
        $criteria = clone Content::model()
            ->byLabels([Label::LABEL_FORUMS])
            ->getDbCriteria()
        ;

        $criteria->compare('authorId', '<>' . \User::HAPPY_GIRAFFE);
        $criteria->group = 'authorId';
        $criteria->addCondition(new \CDbExpression('MONTH(FROM_UNIXTIME(dtimeCreate)) = MONTH(CURDATE()) AND YEAR(FROM_UNIXTIME(dtimeCreate)) = YEAR(CURDATE())'));
        return;
    }
}