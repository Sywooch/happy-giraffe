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
    const MONTH_THRESHOLD = 10;

    public $limit = 5;

    protected $scores = [];

    public function run()
    {
        $rows = $this->getRows();
        if (! empty($rows)) {
            $this->render('view', compact('rows'));
        }
    }

    protected function getTimeFrom()
    {
        if (date("j") > self::MONTH_THRESHOLD) {
            $time = strtotime("first day of this month", strtotime(date("Y-m")));
        } else {
            $time = strtotime("first day of last month", strtotime(date("Y-m")));
        }
        return $time;
    }

    protected function getTimeTo()
    {
        return strtotime("first day of next month", $this->getTimeFrom());
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
        return array_slice($this->scores, 0, $this->limit, true);
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
        $criteria = clone Content::model()->getDbCriteria();
        $criteria->scopes = ['byLabels' => [Label::LABEL_FORUMS]];
        $criteria->compare('authorId', '<>' . \User::HAPPY_GIRAFFE);
        $criteria->select = 'authorId uId, COUNT(*) c';
        $criteria->group = 'authorId';
        $criteria->params[':timeFrom'] = $this->getTimeFrom();
        $criteria->addCondition('dtimeCreate > :timeFrom');
        if (time() > $this->getTimeTo()) {
            $criteria[':timeTo'] = $this->getTimeTo();
            $criteria->addCondition('dtimeCreate < :timeTo');
        }
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
        $this->processQuery($rows, self::POSTS_MULTIPLIER);
    }

    /**
     * @todo обсудить
     */
    protected function chargeCommentsScore()
    {
        $label = Label::model()->byTags(Label::LABEL_FORUMS)->find();
        if ($label === null) {
            return;
        }

        $criteria = clone Comment::model()->getDbCriteria();
        $criteria->select = 'author_id uId, COUNT(*) c';
        $criteria->group = 'author_id';
        $criteria->params[':timeFrom'] = date("Y-m-d H:i:s", $this->getTimeFrom());
        $criteria->addCondition('created > :timeFrom');
        if (time() > $this->getTimeTo()) {
            $criteria[':timeTo'] = date("Y-m-d H:i:s", $this->getTimeTo());
            $criteria->addCondition('created < :timeTo');
        }
        $criteria->addCondition("`new_entity_id` IN (
            SELECT `contentId`
            FROM `post__tags`
            WHERE `labelId` IN (" . $label->id . ")
            GROUP BY `contentId`
            HAVING COUNT(labelId) = 1
        )");
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria)->queryAll();
        $this->processQuery($rows, self::COMMENTS_MULTIPLIER);
    }

    protected function processQuery($input, $multiplier = 1)
    {
        foreach ($input as $row) {
            $this->charge($row['uId'], $row['c'] * $multiplier);
        }
    }
}