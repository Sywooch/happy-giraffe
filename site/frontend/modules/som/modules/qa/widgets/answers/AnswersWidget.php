<?php
namespace site\frontend\modules\som\modules\qa\widgets\answers;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\components\QaManager;

/**
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer[] $answers
 */
class AnswersWidget extends \CWidget
{
    /**
     * @var \site\frontend\modules\som\modules\qa\models\QaQuestion
     */
    public $question;

    public function run()
    {
        if (\Yii::app()->user->isGuest) {
            $this->runForGuest();
        } else {
            $this->runForUser();
        }
    }

    protected function runForGuest()
    {
        $answers = QaManager::getAnswers($this->question);

        $bestAnswers = array();
        $otherAnswers = array();

        foreach ($answers as $answer)
        {
            if ($answer->isBest) {
                $bestAnswers[] = $answer;
            } else {
                $otherAnswers[] = $answer;
            }
        }
        $this->render('view', compact('bestAnswers', 'otherAnswers'));
    }

    protected function runForUser()
    {
       $params = array(
            'questionId'                => $this->question->id,
            'categoryId'                => $this->question->categoryId,
            'pediatricianCategoryId'    => QaCategory::PEDIATRICIAN_ID,
            'channelId'                 => self::getChannelIdByQuestion($this->question),
        );
        $paramsParts = array_map(function($value, $key) {
            return $key . ': ' . \CJSON::encode($value);
        }, $params, array_keys($params));

        $paramsStr = implode(', ', $paramsParts);
        echo \CHtml::tag('answers-widget', array('params' => $paramsStr));
    }

    public static function getChannelIdByQuestion($question)
    {
        if ($question instanceof QaQuestion) {
            $question = $question->id;
        }

        return 'AnswersWidget_' . $question;
    }
}