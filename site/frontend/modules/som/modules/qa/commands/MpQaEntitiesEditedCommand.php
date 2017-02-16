<?php

namespace site\frontend\modules\som\modules\qa\commands;

use Aws\CloudFront\Exception\Exception;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * Class MpQaEntitiesEditedCommand
 *
 * @author Sergey Gubarev
 */
class MpQaEntitiesEditedCommand extends \CConsoleCommand
{

    public function actionWatch()
    {
        $pos = 1;

        while (true)
        {
            try
            {
                foreach (\Yii::app()->comet->cmdWatch($pos) as $event)
                {
                    $this->_writeLog($event);

                    if ($event['event'] == "offline")
                    {
                        $eventId = $event['id'];

                        if (($prefixPos = mb_strpos($eventId, QaQuestion::COMET_CHANNEL_ID_EDITED_PREFIX, 0, 'UTF-8')) !== false)
                        {
                            $channelId = mb_substr($eventId, 0, $prefixPos, 'UTF-8');

                            $this->_deleteObjectFromMongo($channelId);
                        }
                    }

                    $pos = $event['pos'];
                }
            }
            catch (Exception $e)
            {
                echo "Exception: {$e->getMessage()}\n";
            }

            sleep(1);
        }
    }

    /** -------------------------------------------------------------------------------------------------------- */

    /**
     * Удаляет объект вопроса из коллекции редактируемых вопросов в Mongo
     *
     * @param $channelId ID comet-канала
     */
    private function _deleteObjectFromMongo($channelId)
    {
        preg_match_all('/[0-9]+/', $channelId, $matches);

        $questionId = (int) $matches[0][0];

        if (isset($matches[0][1]))
        {
            $answerId = $matches[0][1];

            QaManager::deleteAnswerObjectFromCollectionByAttr([
                'answerId' => $answerId
            ]);
        }

        QaManager::deleteQuestionObjectFromCollection($questionId);
    }

    /**
     * Пишет лог в консоль
     *
     * @param object $event Событие
     */
    private function _writeLog($event)
    {
        echo "[" . date("r") . "] Received: {$event['event']} - {$event['id']}\n";
    }

}