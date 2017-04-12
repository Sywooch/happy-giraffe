<?php

namespace site\frontend\modules\som\modules\qa\widgets\usersTop;

use site\frontend\components\TopWidgetAbstract;
use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\components\api\models\User;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

/**
 * @author Emil Vililyaev
 */
class NewUsersTopWidget extends UsersTopWidget
{

    /**
     * @var integer
     */
    const nameLengthLimit = 17;

    /**
     * @var boolean
     * in list only users or ONLY specialists, all users need implement
     */
    public $onlyUsers = TRUE;

    /**
     * @see \site\frontend\components\TopWidgetAbstract
     * @var integer
     */
    protected $_monthThreshold = 1;

    /**
     * Триггер поведения кеша
     * @var boolean
     */
    protected $useCache = true;

    /**
     * Время жизни кеша
     * @var integer
     */
    protected $cacheExpire = 600;

    /**
     * @param string $name
     * @return string
     */
    public function formattedName($name)
    {
        if (!is_string($name) || mb_strlen($name, 'UTF-8') < self::nameLengthLimit)
        {
            return $name;
        }

        return mb_substr($name, 0, self::nameLengthLimit - 1, 'UTF-8') . '&#8230';
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\modules\som\modules\qa\widgets\usersTop\UsersTopWidget::init()
     */
    public function init()
    {
        $this->setViewName($this->viewFileName);
        $this->_setTitle();
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::getData()
     */
    public function getData()
    {
        $cacheId = 'NewUsersTopWidget.' . $this->getTitle();
        $rows = $this->useCache ? $this->getCacheComponent()->get($cacheId) : null;

        if(empty($rows)){

            $this->_process($this->onlyUsers);

            $top = array_slice($this->scores, 0, $this->getLimit(), true);

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

            if($this->useCache){
                $this->getCacheComponent()->set($cacheId, $rows, $this->cacheExpire);
            }
        }

        if (empty($rows))
        {
            return; //@todo Emil Vililyaev: для того чтобы не проверять if (!empty($data['rows'])... нужно отрефакторить все зависимые view
        }

        return ['rows' => $rows];
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::_process()
     */
    protected function _process($onlyUsers = TRUE)
    {
        $answerCount = $this->_getAnswersCount($onlyUsers);
        $votesCount = $this->_getVotesCount($onlyUsers);
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

    private function _getAnswersCount($onlyUsers = TRUE)
    {
        $answerTableName = QaAnswer::model()->tableName();
        $questionsTableName = QaQuestion::model()->tableName();
        $cmd = \Yii::app()->db->createCommand()
            ->select($answerTableName . '.authorId, COUNT(*) AS `count`')
            ->from($answerTableName)
            ->leftJoin($questionsTableName, $answerTableName . '.questionId = ' . $questionsTableName . '.id AND ' . $questionsTableName . '.isRemoved = 0')
            ->where($answerTableName . '.isRemoved=0')
            ->andWhere($answerTableName . '.dtimeCreate > ' . $this->_getTimeFrom())
            ->andWhere($answerTableName . '.dtimeCreate < ' . $this->_getTimeTo())
            ->andWhere($questionsTableName . '.categoryId=' . QaCategory::PEDIATRICIAN_ID)
        ;

        if ($onlyUsers)
        {
            $cmd->andWhere($answerTableName . '.authorId NOT IN (SELECT id FROM specialists__profiles)');
        } else {
            $cmd->andWhere($answerTableName . '.authorId IN (SELECT id FROM specialists__profiles)');
        }

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

    private function _getVotesCount($onlyUsers = TRUE)
    {
        $votesTableName = QaAnswerVote::model()->tableName();
        $answerTableName = QaAnswer::model()->tableName();
        $cmd = \Yii::app()->db->createCommand()
            ->select($answerTableName . '.authorId, COUNT(*) AS `count`')
            ->join($answerTableName, $answerTableName . '.id = ' . $votesTableName . '.answerId')
            ->andWhere($votesTableName . '.dtimeCreate > ' . $this->_getTimeFrom())
            ->andWhere($votesTableName . '.dtimeCreate < ' . $this->_getTimeTo())
            ->from($votesTableName)
        ;

        if ($onlyUsers)
        {
            $cmd->andWhere($answerTableName . '.authorId NOT IN (SELECT id FROM specialists__profiles)');
        } else {
            $cmd->andWhere($answerTableName . '.authorId IN (SELECT id FROM specialists__profiles)');
        }

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

    /**
     *
     * @return \CCache
     */
    protected function getCacheComponent()
    {
        return \Yii::app()->getComponent('dbCache');
    }
}
