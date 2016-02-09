<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\som\modules\qa\models\QaQuestion;

class QuestionsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getQuestions', null, null, null);
    }

    public function getQuestions()
    {
        $this->controller->get(QaQuestion::model(), $this);
    }
}