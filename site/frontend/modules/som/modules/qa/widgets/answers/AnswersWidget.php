<?php
namespace site\frontend\modules\som\modules\qa\widgets\answers;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

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

    public function getBestAnswer()
    {
        return $this->question->bestAnswer;
    }

    public function getAnswers()
    {
        return QaAnswer::model()->question($this->question->id)->apiWith('user')->findAll('t.id <> :best', array(':best' => $this->getBestAnswer()->id));
    }

    protected function runForGuest()
    {
        $bestAnswer = $this->getBestAnswer();
        $answers = $this->getAnswers();
        $this->render('view', compact('bestAnswer', 'answers'));
    }

    protected function getDataProvider()
    {
        return new \CActiveDataProvider(QaAnswer::model());
    }

    protected function runForUser()
    {
        $params = array(
            'questionId' => $this->question->id,
            'channelId' => self::getChannelIdByQuestion($this->question),
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

    public static function getChannelIdByAnswer($answer)
    {
        if (! $answer instanceof QaAnswer) {
            $answerId = (is_array($answer) ? $answer['id'] : $answer);
            $answer = QaAnswer::model()->resetScope()->findByPk($answerId);
            if ($answer === null) {
                throw new \CException('Invalid answer');
            }
        }
        return self::getChannelIdByQuestion($answer->questionId);
    }
}