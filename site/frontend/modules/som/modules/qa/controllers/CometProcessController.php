<?php

namespace site\frontend\modules\som\modules\qa\controllers;

use site\frontend\components\api\ApiController;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerEditing;

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
     * @param boolean $isRoot       Рутовый ответ или нет (комментарий)
     */
    public function actionAnswerEdited($questionId, $answerId, $isRoot)
    {
        $channelId = QaManager::getQuestionChannelId($questionId);

        $this->send($channelId, compact('answerId', 'isRoot'), \CometModel::MP_QUESTION_ANSWER_EDITED);

        $findObject = QaManager::isAnswerEditing($answerId);

        if (!$findObject)
        {
            $object = new QaAnswerEditing();
            $object->answerId   = $answerId;
            $object->questionId = $questionId;
            $object->save();
        }

        $answer = QaAnswer::model()->findByPk($answerId);

        $this->data = [
            'channelId' => $answer->channelId()
        ];
    }

    /**
     * Отмена редактирования ответа
     *
     * @param integer $questionId   ID вопроса
     * @param integer $answerId     ID ответа
     * @param boolean $isRoot       Рутовый ответ или нет (комментарий)
     */
    public function actionAnswerCancelEdited($questionId, $answerId, $isRoot)
    {
        $channelId = QaManager::getQuestionChannelId($questionId);

        $this->send($channelId, ['status' => false, 'answerId' => $answerId, 'isRoot' => $isRoot], \CometModel::MP_QUESTION_ANSWER_FINISH_EDITED);

        $findObject = QaAnswerEditing::model()->find([
            'answerId' => $answerId
        ]);

        if ($findObject)
        {
            $findObject->delete();
        }
    }

}