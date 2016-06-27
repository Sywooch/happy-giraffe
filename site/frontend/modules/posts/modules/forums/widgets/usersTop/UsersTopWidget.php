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
    const POSTS_COUNT_MULTIPLIER = 5;
    const COMMENTS_COUNT_MULTIPLIER = 1;
    const POSTS_QUALITY_VIEW_WEIGHT = 0.01;
    const POSTS_QUALITY_COMMENT_WEIGHT = 0.1;
    const MONTH_THRESHOLD = 10;

    public $limit = 5;
    public $labels = [];

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
        $this->chargeAll();
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

    protected function chargeAll()
    {
        $this->chargePostCounts();
        $this->chargeCommentsCounts();
        $this->chargePostsQuality();
    }

    protected function getPostsCommonCriteria()
    {
        $criteria = Content::model()->byLabels($this->labels)->getDbCriteria();
        Content::model()->resetScope(false);
        $criteria->compare('authorId', '<>' . \User::HAPPY_GIRAFFE);
        $criteria->params[':timeFrom'] = $this->getTimeFrom();
        $criteria->addCondition('dtimePublication > :timeFrom');
        if (time() > $this->getTimeTo()) {
            $criteria[':timeTo'] = $this->getTimeTo();
            $criteria->addCondition('dtimePublication < :timeTo');
        }
        return $criteria;
    }

    protected function chargePostCounts()
    {
        $criteria = $this->getPostsCommonCriteria();
        $criteria->select = 'authorId uId, COUNT(*) c';
        $criteria->group = 'authorId';
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
        $this->processQuery($rows, self::POSTS_COUNT_MULTIPLIER);
    }

    protected function chargePostsQuality()
    {
        $criteria = $this->getPostsCommonCriteria();
        $criteria->select = 'url, authorId uId, COUNT(*) c';
        $criteria->join = 'JOIN comments cm ON cm.new_entity_id = t.id';
        $criteria->group = 't.id';
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();
        foreach ($rows as $row) {
            $views = \Yii::app()->getModule('analytics')->visitsManager->getVisits($row['url']);
            $score = $views * self::POSTS_QUALITY_VIEW_WEIGHT + $row['c'] * self::POSTS_QUALITY_COMMENT_WEIGHT;
            $this->charge($row['uId'], $score);
        }
    }

    /**
     * @todo обсудить использование new_entity_id
     */
    protected function chargeCommentsCounts()
    {
        $criteria = clone Comment::model()->getDbCriteria();
        $criteria->select = 'author_id uId, COUNT(*) c';
        $criteria->group = 'author_id';
        $criteria->params[':timeFrom'] = date("Y-m-d H:i:s", $this->getTimeFrom());
        $criteria->addCondition('created > :timeFrom');
        if (time() > $this->getTimeTo()) {
            $criteria[':timeTo'] = date("Y-m-d H:i:s", $this->getTimeTo());
            $criteria->addCondition('created < :timeTo');
        }
        $labelsIds = Label::getIdsByLabels($this->labels);
        if (! empty($labelsIds)) {
            $criteria->addCondition('`new_entity_id` IN (
                SELECT `contentId`
                FROM `post__tags`
                WHERE `labelId` IN (' . implode(', ', $labelsIds) . ')
                GROUP BY `contentId`
                HAVING COUNT(labelId) = ' . count($labelsIds) . '
            )');
        }
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria)->queryAll();
        $this->processQuery($rows, self::COMMENTS_COUNT_MULTIPLIER);
    }

    protected function processQuery($input, $multiplier = 1)
    {
        foreach ($input as $row) {
            $this->charge($row['uId'], $row['c'] * $multiplier);
        }
    }
}