<?php
/**
 * @author Никита
 * @date 27/11/15
 */

namespace site\frontend\modules\som\modules\qa\widgets\my;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

\Yii::import('zii.widgets.CMenu');

abstract class PersonalWidget extends \CMenu
{
    public $userId;
    protected $questionsUrl = array('/som/qa/my/questions');
    protected $answersUrl = array('/som/qa/my/answers');

    public function init()
    {
        $this->items = $this->generateItems();
        parent::init();
    }

    public function getQuestionsCount()
    {
        return QaQuestion::model()->user($this->userId)->count();
    }

    public function getAnswersCount()
    {
        return QaAnswer::model()->user($this->userId)->count();
    }

    abstract protected function generateItems();
}