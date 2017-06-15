<?php

namespace site\frontend\modules\chat\components;

interface IChat
{
    /**
     * @param array $participants
     */
    function onCreate($participants);

    /**
     * @param \site\frontend\modules\chat'models\Chat $chat
     * @param string $message
     * @param int $userId
     *
     * @return \site\frontend\modules\chat\models\ChatMessage
     */
    function onMessage($chat, $message, $userId);
}