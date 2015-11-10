<?php
/**
 * @author Никита
 * @date 09/11/15
 */

namespace site\frontend\modules\som\modules\qa\controllers;


use site\frontend\modules\som\modules\qa\models\QaConsultation;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class ApiController extends \site\frontend\components\api\ApiController
{
    public static $answerModel = '\site\frontend\modules\som\modules\qa\models\QaAnswer';

    public function actionCreateAnswer($questionId, $text)
    {
        $answer = new self::$answerModel;
        $answer->attributes = array(
            'questionId' => $questionId,
            'text' => $text,
        );
    }
}