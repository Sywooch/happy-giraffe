<?php

namespace site\frontend\modules\iframe\models;

use site\frontend\modules\iframe\components\api\User;
/**
 *
 */
class Pediatrician extends \HActiveRecord
{
    private $limit = 1000;

    protected $scores = [];
    /*
     * @var boolean
     * выборка по всему периоду
     */
    public $allPeriod = FALSE;

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::getData()
     */
    public function getData()
    {
        $this->process();

        $top = array_slice($this->scores, 0, $this->limit, true);
        $users = User::model()->findAllByPk(array_keys($top), ['avatarSize' => 40]);

        $rows = [];
        foreach ($top as $uId => $score)
        {
            $rows[] = [
                'user' => $users[$uId],
                'score' => $score['total_count'],
                'votes' => $score['votes_count'],
                'answers' => $score['answers_count'],
            ];
        }

        return ['rows' => $rows];
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::_process()
     */
    protected function process()
    {
        $answerCount = $this->_getAnswersCount();
        $votesCount = $this->_getVotesCount();
        $result = array_merge($answerCount, $votesCount);

        if (empty($result))
        {
            return;
        }

        foreach ($result as $item)
        {
            if (array_key_exists($item['userId'], $this->scores))
            {
                $this->scores[$item['userId']]['total_count'] += $item['count'];
            }
            else
            {
                $this->scores[$item['userId']]['total_count'] = (int)$item['count'];
                $this->scores[$item['userId']]['answers_count'] = 0;
                $this->scores[$item['userId']]['votes_count'] = 0;
            }

            if ($item['type'] == 'answer')
            {
                $this->scores[$item['userId']]['answers_count'] += $item['count'];
            }

            if ($item['type'] == 'votes')
            {
                $this->scores[$item['userId']]['votes_count'] += $item['count'];
            }

        }


        uasort($this->scores, function($a, $b){
            if ($a['total_count'] < $b['total_count'])
            {
                return 1;
            }

            return 0;
        });
    }

    private function _getAnswersCount()
    {
        $answerTableName = QaAnswer::model()->tableName();
        $questionsTableName = QaQuestion::model()->tableName();
        $cmd = \Yii::app()->db->createCommand()
            ->select($answerTableName . '.authorId, COUNT(*) AS `count`')
            ->from($answerTableName)
            ->leftJoin($questionsTableName, $answerTableName . '.questionId = ' . $questionsTableName . '.id AND ' . $questionsTableName . '.isRemoved = 0')
            ->where($answerTableName . '.isRemoved=0')
            ->andWhere($answerTableName . '.authorId IN (SELECT id FROM specialists__profiles)')
            ->andWhere($questionsTableName . '.categoryId=' . QaCategory::PEDIATRICIAN_ID);

        $list = $cmd
            ->group($answerTableName . '.authorId')
            ->order('count DESC')
            ->queryAll()
        ;

        $answers = [];

        foreach ($list as $item)
        {
            $answers[] = ['userId' => $item['authorId'], 'count' => $item['count'], 'type' => 'answer'];
        }

        return $answers;
    }

    private function _getVotesCount()
    {
        $votesTableName = QaAnswerVote::model()->tableName();
        $answerTableName = QaAnswer::model()->tableName();
        $cmd = \Yii::app()->db->createCommand()
            ->select($answerTableName . '.authorId, COUNT(*) AS `count`')
            ->join($answerTableName, $answerTableName . '.id = ' . $votesTableName . '.answerId')
            ->from($votesTableName)
            ->andWhere($answerTableName . '.authorId IN (SELECT id FROM specialists__profiles)');

        $list = $cmd
            ->group($answerTableName . '.authorId')
            ->order('count DESC')
            ->queryAll()
        ;

        $votes = [];

        foreach ($list as $item)
        {
            $votes[] = ['userId' => $item['authorId'], 'count' => $item['count'], 'type' => 'votes'];
        }

        return $votes;
    }
}
