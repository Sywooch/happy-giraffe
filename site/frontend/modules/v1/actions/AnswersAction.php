<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\som\modules\qa\models\QaAnswer;

class AnswersAction extends RoutedAction
{
    public function run()
    {
        $this->route('getAnswers', null, null, null);
    }

    public function getAnswers()
    {
        if (\Yii::app()->request->getParam('question_id', null)) {
            $where = 'questionId = ' . \Yii::app()->request->getParam('question_id');
            $this->controller->get(QaAnswer::model(), $this, $where);
        } else {
            $this->controller->get(QaAnswer::model(), $this);
        }
    }
}