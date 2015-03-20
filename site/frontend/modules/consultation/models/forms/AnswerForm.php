<?php
namespace site\frontend\modules\consultation\models\forms;
use site\frontend\modules\consultation\models\ConsultationQuestion;
use site\frontend\modules\consultation\models\ConsultationConsultant;
use site\frontend\modules\consultation\models\ConsultationAnswer;

/**
 * @author Никита
 * @date 20/03/15
 */

class AnswerForm extends \CFormModel
{
    public $text;
    public $questionId;

    public function rules()
    {
        return array(
            array('text', 'required'),
            array('text', 'length', 'min' => 40, 'max' => 10000),
            array('questionId', 'exist', 'className' => 'site\frontend\modules\consultation\models\ConsultationQuestion'),
        );
    }

    public function save()
    {
        $answer = new ConsultationAnswer();
        $answer->attributes = $this->attributes;
        $answer->consultantId = $this->getConsultant()->id;
        return $answer->save(false);
    }

    protected function getConsultant()
    {
        if (\Yii::app()->user->isGuest) {
            return null;
        }

        $question = $this->getQuestion();
        $consultant = ConsultationConsultant::model()->user(\Yii::app()->user->id)->consultation($question->consultationId)->find();
        return $consultant;
    }

    protected function getQuestion()
    {
        return ConsultationQuestion::model()->findByPk($this->questionId);
    }
}