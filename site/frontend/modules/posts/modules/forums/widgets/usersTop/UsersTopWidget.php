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
    const MONTH_THRESHOLD = 10;

    protected $scores = [];

    public function run()
    {
        $rows = $this->getRows();
        if (! empty($rows)) {
            $this->render('view', compact('rows'));
        }
    }

    protected function getTime()
    {
        if (date("j") > self::MONTH_THRESHOLD) {
            $time = time();
        } else {
            $time = strtotime("first day of last month");
        }
        return $time;
    }

    protected function getRows()
    {
        $top = $this->getTop();
        $users = User::model()->findAllByPk(array_keys($top), array('avatarSize' => 40));
        $rows = [];
        foreach ($top as $uId => $score) {
            $rows[] = [
                'user' => $users[$uId],
                'score' => $score,
            ];
        }
        return $rows;
    }

    protected function getTop()
    {
        $this->chargePostScore();
        $this->chargeCommentsScore();
        arsort($this->scores);
        return array_slice($this->scores, 0, self::LIMIT, true);
    }

    protected function charge($userId, $score)
    {
        if (! isset ($this->scores[$userId])) {
            $this->scores[$userId] = 0;
        }
        $this->scores[$userId] += $score;
    }

    protected function chargePostScore()
    {
        $criteria = $this->getPostsCriteria();
        $criteria->compare('authorId', '<>' . \User::HAPPY_GIRAFFE);
        $criteria->select = 'authorId uId, COUNT(*) c';
        $criteria->group = 'authorId';
        //$criteria->params[':month'] = date("n", $this->getTime());
        //$criteria->addCondition(new \CDbExpression('MONTH(FROM_UNIXTIME(dtimeCreate)) = :month AND YEAR(FROM_UNIXTIME(dtimeCreate)) = YEAR(CURDATE())'));
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
        $this->processQuery($rows, self::POSTS_MULTIPLIER);
    }

    protected function chargeCommentsScore()
    {
        $criteria = $this->getPostsCriteria();
        $criteria->select = 'comments.author_id uId, COUNT(*) c';
        $criteria->join = 'JOIN comments ON comments.entity_id = t.originEntityId AND comments.entity = t.originEntity';
        $criteria->group = 'author_id';
        //$criteria->params[':month'] = date("n", $this->getTime());
        //$criteria->addCondition(new \CDbExpression('MONTH(comments.created) = :month AND YEAR(FROM_UNIXTIME(dtimeCreate)) = YEAR(CURDATE())'));
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
        $this->processQuery($rows, self::COMMENTS_MULTIPLIER);
    }

    protected function processQuery($input, $multiplier = 1)
    {
        foreach ($input as $row) {
            $this->charge($row['uId'], $row['c'] * $multiplier);
        }
    }

    /**
     * @return \CDbCriteria
     */
    protected function getPostsCriteria()
    {
        $criteria = clone Content::model()->getDbCriteria();
        $criteria->scopes = ['byLabels' => [Label::LABEL_FORUMS]];
        return $criteria;
    }
}