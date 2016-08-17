<?php

namespace site\frontend\modules\posts\components;

use site\frontend\components\TopWidgetAbstract;
use site\frontend\components\api\models\User;
use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\posts\components\UserTopWidget;

/**
 * @author Emil Vililyaev
 */
class UserTopWidget extends TopWidgetAbstract
{

    const POSTS_COUNT_MULTIPLIER = 5;
    const COMMENTS_COUNT_MULTIPLIER = 1;
    const POSTS_QUALITY_VIEW_WEIGHT = 0.01;
    const POSTS_QUALITY_COMMENT_WEIGHT = 0.1;
    const MONTH_THRESHOLD = 10;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Разделы для формирования запросов
     *
     * @var array
     */
    public $labels = [];

    //-----------------------------------------------------------------------------------------------------------

    /**
     * @var string
     */
    private $_titlePrefix;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::getTitle()
     */
    public function getTitle()
    {
        return $this->_titlePrefix . ' ' . \Yii::app()->dateFormatter->format('MMMM', $this->_getTimeFrom());
    }

    /**
     * @param string $name
     */
    public function setTitlePrefix($name)
    {
        $this->_titlePrefix = $name;
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Выбираем данные (для будущих расчетов)
     */
    protected function _process()
    {
        $this->_chargePostCounts();
        $this->_chargeCommentsCounts();
        $this->_chargePostsQuality();
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * Добавляем данные в хранилище
     *
     * @param integer $userId
     * @param integer $score
     */
    private function _charge($userId, $score)
    {
        if (! isset ($this->scores[$userId])) {
            $this->scores[$userId] = 0;
        }
        $this->scores[$userId] += $score;
    }

    /**
     * Общий критерий запроса для постов
     *
     * @return \CDbCriteria
     */
    private function _getPostsCommonCriteria()
    {
        $criteria = Content::model()->byLabels($this->labels)->getDbCriteria();

        Content::model()->resetScope(false);

        $criteria->compare('authorId', '<>' . \User::HAPPY_GIRAFFE);
        $criteria->params[':timeFrom'] = $this->_getTimeFrom();
        $criteria->addCondition('dtimePublication > :timeFrom');
        $criteria->limit = $this->getLimit();
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
    private function _chargePostCounts()
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
    private function _chargePostsQuality()
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
    private function _chargeCommentsCounts()
    {
        $criteria = clone Comment::model()->getDbCriteria();
        $criteria->limit = $this->getLimit();
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

        if ( empty($labelsIds))
        {
            $criteria->addCondition('`new_entity_id` IN (
                SELECT `contentId`
                FROM `post__tags`
                WHERE `labelId` IN (' . implode(', ', $labelsIds) . ')
                GROUP BY `contentId`
                HAVING COUNT(labelId) = ' . count($labelsIds) . '
            )');
        }

//         $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria)->queryAll();
        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand(Comment::model()->tableName(), $criteria);
        var_dump($rows->getText());exit;

        $this->_processQuery($rows, self::COMMENTS_COUNT_MULTIPLIER);
    }

    /**
     * Парсинг результата запроса для добавления нужных параметров в хранилище
     *
     * @param array $input
     * @param number $multiplier
     */
    private function _processQuery($input, $multiplier = 1)
    {
        foreach ($input as $row)
        {
            $this->_charge($row['uId'], $row['c'] * $multiplier);
        }
    }
}