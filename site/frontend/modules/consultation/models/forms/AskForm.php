<?php
namespace site\frontend\modules\consultation\models\forms;
use site\frontend\modules\consultation\models\ConsultationQuestion;


/**
 * @author Никита
 * @date 20/03/15
 */

class AskForm extends \CFormModel
{
    public $title;
    public $test;
    public $consultationId;

    public function rules()
    {
        return array(
            array('title, text', 'required'),
            array('title', 'length', 'max' => 255),
            array('text', 'length', 'min' => 40, 'max' => 10000),
            array('consultationId', 'exist', 'className' => 'site\frontend\modules\consultation\models\Consultation'),
        );
    }

    public function save()
    {
        $question = new ConsultationQuestion();
        $question->attributes = $this->attributes;
        return $question->save(false);
    }
}