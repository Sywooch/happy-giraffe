<?php
namespace site\frontend\modules\consultation\widgets;
use site\frontend\modules\consultation\models\ConsultationQuestion;

/**
 * @author Никита
 * @date 29/03/15
 */

class OtherQuestionsWidget extends \CWidget
{
    const LIMIT = 5;

    public $question;

    public function run()
    {
        $questions = $this->getQuestions();
        $count = ConsultationQuestion::model()->count();


        if ($questions) {
            $this->render('OtherQuestionsWidget', compact('questions', 'count'));
        }
    }

    protected function getQuestions()
    {
        $criteria = new \CDbCriteria();
        $criteria->compare('id', '<>' . $this->question->id);
        $criteria->limit = self::LIMIT;
        return ConsultationQuestion::model()->findAll($criteria);
    }
}