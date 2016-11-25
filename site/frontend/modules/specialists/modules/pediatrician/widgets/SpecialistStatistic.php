<?php

namespace site\frontend\modules\specialists\modules\pediatrician\widgets;

use site\frontend\modules\specialists\modules\pediatrician\components\QaManager;
/**
 * @author Emil Vililyaev
 */
class SpecialistStatistic extends \CWidget
{

    /**
     * @var integer
     */
    public $viewName;

    /**
     * @var integer
     */
    private $_answerCount;

    /**
     * @var integer
     */
    private $_votesCount;

    //-----------------------------------------------------------------------------------------------------------

    /**
     * {@inheritDoc}
     * @see CWidget::init()
     */
    public function init()
    {
        /*@var $user \WebUser */
        $user = \Yii::app()->user;

        if (is_null($user))
        {
            return;
        }

        $arrData = QaManager::getAnswerCountAndVotes($user->getId());

        if (!is_array($arrData) || !array_key_exists('count', $arrData) || !array_key_exists('sumVotes', $arrData))
        {
            return;
        }

        $this->_answerCount = $arrData['count'];
        $this->_votesCount  = $arrData['sumVotes'];
    }

    /**
     * {@inheritDoc}
     * @see CWidget::run()
     */
    public function run()
    {
        if(is_null($this->_answerCount) || is_null($this->_votesCount))
        {
            return;
        }

        $this->render($this->viewName, ['answerCount' => $this->_answerCount, 'votesCount' => $this->_votesCount]);
    }

}