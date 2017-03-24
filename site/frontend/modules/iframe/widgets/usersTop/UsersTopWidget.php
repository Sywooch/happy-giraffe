<?php

namespace site\frontend\modules\iframe\widgets\usersTop;

use site\frontend\modules\iframe\models\QaAnswer;
use site\frontend\components\TopWidgetAbstract;
use site\frontend\modules\specialists\models\SpecialistProfile;

/**
 * @author Emil Vililyaev
 */
class UsersTopWidget extends TopWidgetAbstract
{

    /**
     * @var integer
     */
    public $authorId;

    /**
     * @var string
     */
    public $titlePrefix;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $viewFileName;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * @var \site\frontend\modules\som\modules\qa\models\QaAnswer
     */
    private $_model;

    /**
     * @var integer
     */
    private $_rating;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::init()
     */
    public function init()
    {
        $this->setViewName($this->viewFileName);
        $this->_model = QaAnswer::model();

        if (!is_null($this->authorId))
        {
            $this->_monthThreshold = 0;
        }
    }

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::getTitle()
     */
     public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return number
     */
    public function getRating()
    {
        return $this->_rating;
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see \site\frontend\components\TopWidgetAbstract::_process()
     */
    protected function _process()
    {
        $this->_getRating();

        if (!is_null($this->authorId))
        {
            $this->_getRatingForAuthor();
        }

        $this->_setTitle();

        arsort($this->scores);
    }

    /**
     * set default title
     */
    protected function _setTitle()
    {
        if (is_null($this->title))
        {
            $this->title = $this->titlePrefix . ' ' . \Yii::app()->dateFormatter->format('MMMM', $this->_getTimeFrom());
        }
    }

    //-----------------------------------------------------------------------------------------------------------

    /**
     * set raiting for one member
     */
    private function _getRatingForAuthor()
    {
        $authorScore = isset($this->scores[$this->authorId]) ? $this->scores[$this->authorId] : 0;

        $cmd = \Yii::app()->db->createCommand()
            ->select('authorId, cc, COUNT(*) AS count')
            ->from('(SELECT authorId ,SUM(qa.votesCount) + COUNT(*) AS cc FROM qa__answers qa GROUP BY qa.authorId ORDER BY cc DESC, authorId DESC) AS t1')
            ->where('cc > ' . $authorScore);

        $result = $cmd->queryAll();

        $this->_rating = (int)$result[0]['count'];
    }

    /**
     * calculate raiting
     */
    private function _getRating()
    {
        $criteria           = clone $this->_model->getDbCriteria();
        $specialistCriteria = clone SpecialistProfile::model()->getDbCriteria();

        $specialistCriteria->select = 'id';
        $specialistIdList = \Yii::app()->db->getCommandBuilder()->createFindCommand(SpecialistProfile::model()->tableName(), $specialistCriteria)->queryAll();

        $exludeIdList[] = \User::HAPPY_GIRAFFE;

        if (!is_null($specialistIdList))
        {
            $exludeIdList = array_merge($exludeIdList, array_map(function($value){
                return (int)$value['id'];
            }, $specialistIdList));
        }

        $this->_model->resetScope(false);

        $criteria->select = 'authorId, SUM(votesCount) + COUNT(*) c';

        $criteria->params[':timeFrom'] = $this->_getTimeFrom();
        $criteria->addCondition('dtimeCreate > :timeFrom');

        if (is_null($this->authorId))
        {
            $criteria->addCondition('authorId NOT IN (' . implode(',', $exludeIdList) . ')');
        }
        else
        {
            $criteria->addCondition('authorId = ' . $this->authorId);
        }

        $criteria->limit = $this->getLimit();
        $criteria->group = 'authorId';
        $criteria->order = 'c DESC, authorId DESC';


        if (time() > $this->_getTimeTo())
        {
            $criteria->params[':timeTo'] = $this->_getTimeTo();
            $criteria->addCondition('dtimeCreate < :timeTo');
        }

        $rows = \Yii::app()->db->getCommandBuilder()->createFindCommand($this->_model->tableName(), $criteria)->queryAll();

        array_walk($rows, function ($arrData)
        {
            $this->scores[$arrData['authorId']] = $arrData['c'];
        });
    }

}