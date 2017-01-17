<?php

namespace site\frontend\modules\som\modules\qa\controllers;

use site\frontend\components\api\ApiController;

/**
 * Class CometProcessController
 *
 * @package site\frontend\modules\som\modules\qa\controllers
 * @author Sergey Gubarev
 */
class CometProcessController extends ApiController
{

    /**
     * Процесс редактирования ответа
     *
     * @param integer $answerId ID ответа
     */
    public function actionAnswerEdited($answerId)
    {
        $this->send(\CometModel::MP_QUESTION_CHANEL_ID, compact('answerId'), \CometModel::MP_QUESTION_ANSWER_EDITED);
    }

}