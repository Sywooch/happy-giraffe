<?php

namespace site\frontend\modules\posts\modules\blogs\widgets\usersTop;

use site\frontend\components\api\models\User;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\models\Tag;

/**
 * @author Sergey Gubarev
 */
class UsersTopWidget extends \CWidget
{

    const POSTS_COUNT_MULTIPLIER = 5;
    const COMMENTS_COUNT_MULTIPLIER = 1;
    const POSTS_QUALITY_VIEW_WEIGHT = 0.01;
    const POSTS_QUALITY_COMMENT_WEIGHT = 0.1;
    const MONTH_THRESHOLD = 10;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Лимит кол-ва блогеров при выводе
     *
     * @var integer
     */
    public $limit = 5;

    /**
     * Разделы для формирования запросов
     *
     * @var array
     */
    public $labels = [];


    /**
     * Хранилище - собирает все данные (без PHP лимита)
     *
     * @var array
     */
    protected $scores = [];

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        $rows = $this->_getRows();

        if (! empty($rows))
        {
            $this->render('view', compact('rows'));
        }
    }

    /**
     * Название месяца в шаблоне
     *
     * @return string
     */
    public function getMonthName()
    {
       return \Yii::app()->dateFormatter->format('MMMM', $this->_getTimeFrom());
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Timestamp начала периода выборки
     *
     * @return number
     */
    protected function _getTimeFrom()
    {
        if (date("j") > self::MONTH_THRESHOLD)
        {
            $time = strtotime("first day of this month", strtotime(date("Y-m")));
        }
        else
        {
            $time = strtotime("first day of last month", strtotime(date("Y-m")));
        }

        return $time;
    }


    /**
     * Timestamp конца периода выборки
     *
     * @return number
     */
    protected function _getTimeTo()
    {
        return strtotime("first day of next month", $this->_getTimeFrom());
    }

    /**
     * Результат
     *
     * @return array
     */
    protected function _getRows()
    {
        $top = $this->_getTop();

        $users = User::model()->findAllByPk(array_keys($top), array('avatarSize' => 40));

        $rows = [];

        foreach ($top as $uId => $score)
        {
            $rows[] = [
                'user' => $users[$uId],
                'score' => $score,
            ];
        }

        return $rows;
    }

    /**
     * Выбираем строки по лимиту с результатов
     *
     * @return array
     */
    protected function _getTop()
    {
        $this->_chargeAll();
        arsort($this->scores);

        return array_slice($this->scores, 0, $this->limit, true);
    }

    /**
     * Добавляем данные в хранилище
     *
     * @param integer $userId
     * @param integer $score
     */
    protected function _charge($userId, $score)
    {
        if (! isset ($this->scores[$userId])) {
            $this->scores[$userId] = 0;
        }
        $this->scores[$userId] += $score;
    }

    /**
     * Выбираем данные (для будущих расчетов)
     */
    protected function _chargeAll()
    {
        $this->_chargePostCounts();
        $this->_chargeCommentsCounts();
        $this->_chargePostsQuality();
    }

    /**
     * Общий критерий запроса для постов
     *
     * @return CDbCriteria
     */
    protected function _getPostsCommonCriteria()
    {
        $criteria = Content::model()->byLabels($this->labels)->getDbCriteria();

        Content::model()->resetScope(false);

        $criteria->compare('authorId', '<>' . \User::HAPPY_GIRAFFE);
        $criteria->params[':timeFrom'] = $this->_getTimeFrom();
        $criteria->addCondition('dtimePublication > :timeFrom');
        $criteria->limit = $this->limit;
        $criteria->order = 'c DESC';

        if (time() > $this->_getTimeTo())
        {
            $criteria->params[':timeTo'] = $this->_getTimeTo();

            $criteria->addCondition('dtimePublication < :timeTo');
        }

        return $criteria;
    }

    /**
     * Выполнить запрос на кол-во постов
     */
    protected function _chargePostCounts()
    {
        $criteria = $this->_getPostsCommonCriteria();
        $criteria->select = 'authorId uId, COUNT(*) c';
        $criteria->group = 'authorId';

        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();

        $this->_processQuery($rows, self::POSTS_COUNT_MULTIPLIER);
    }

    /**
     * Выполнить запрос на "вес" поста
     */
    protected function _chargePostsQuality()
    {
        $criteria = $this->_getPostsCommonCriteria();
        $criteria->select = 'url, authorId uId, COUNT(*) c';
        $criteria->join = 'JOIN comments cm ON cm.new_entity_id = t.id';
        $criteria->group = 't.id';

        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Content::model()->tableName(), $criteria)->queryAll();

        foreach ($rows as $row)
        {
            $views = \Yii::app()->getModule('analytics')->visitsManager->getVisits($row['url']);

            $score = $views * self::POSTS_QUALITY_VIEW_WEIGHT + $row['c'] * self::POSTS_QUALITY_COMMENT_WEIGHT;

            $this->_charge($row['uId'], $score);
        }
    }

    /**
     * Выполнить запрос на кол-во комментариев
     */
    protected function _chargeCommentsCounts()
    {
        $criteria = clone Comment::model()->getDbCriteria();
        $criteria->limit = $this->limit;
        $criteria->order = 'c DESC';
        $criteria->select = 'author_id uId, COUNT(*) c';
        $criteria->group = 'author_id';
        $criteria->params[':timeFrom'] = date("Y-m-d H:i:s", $this->_getTimeFrom());
        $criteria->addCondition('created > :timeFrom');

        if (time() > $this->_getTimeTo())
        {
            $criteria->params[':timeTo'] = date("Y-m-d H:i:s", $this->_getTimeTo());

            $criteria->addCondition('created < :timeTo');
        }

        $labelsIds = Label::getIdsByLabels($this->labels);

        if (! empty($labelsIds))
        {
            $criteria->addCondition('`new_entity_id` IN (
                SELECT `contentId`
                FROM `post__tags`
                WHERE `labelId` IN (' . implode(', ', $labelsIds) . ')
                GROUP BY `contentId`
                HAVING COUNT(labelId) = ' . count($labelsIds) . '
            )');
        }

        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria)->queryAll();

        $this->_processQuery($rows, self::COMMENTS_COUNT_MULTIPLIER);
    }

    /**
     * Парсинг результата запроса для добавления нужных параметров в хранилище
     *
     * @param array $input
     * @param number $multiplier
     */
    protected function _processQuery($input, $multiplier = 1)
    {
        foreach ($input as $row)
        {
            $this->_charge($row['uId'], $row['c'] * $multiplier);
        }
    }

}