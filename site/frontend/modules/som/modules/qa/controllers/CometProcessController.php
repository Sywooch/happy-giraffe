<?php

namespace site\frontend\modules\som\modules\qa\controllers;

use site\frontend\components\api\ApiController;
use site\frontend\modules\som\modules\qa\components\QaManager;

/**
 * Class CometProcessController
 *
 * Проксирует различные независимые действия клиентам comet-канала вопроса
 *
 * @package site\frontend\modules\som\modules\qa\controllers
 * @author Sergey Gubarev
 */
class CometProcessController extends ApiController
{

    /**
     * Процесс редактирования ответа
     *
     * @param integer $questionId   ID вопроса
     * @param integer $answerId     ID ответа
     */
    public function actionAnswerEdited($questionId, $answerId)
    {
        $channelId = QaManager::getQuestionChannelId($questionId);

        $this->send($channelId, compact('answerId'), \CometModel::MP_QUESTION_ANSWER_EDITED);
    }

    /**
     * Отмена редактирования ответа
     *
     * @param integer $questionId   ID вопроса
     * @param integer $answerId     ID ответа
     */
    public function actionAnswerCancelEdited($questionId, $answerId)
    {
        $channelId = QaManager::getQuestionChannelId($questionId);

        $this->send($channelId, ['status' => false, 'answerId' => $answerId], \CometModel::MP_QUESTION_ANSWER_FINISH_EDITED);
    }

}