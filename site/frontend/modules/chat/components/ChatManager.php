<?php

namespace site\frontend\modules\chat\components;

use site\frontend\modules\chat\models\UsersChats;
use site\frontend\modules\chat\values\ChatTypes;

class ChatManager
{
    private static $chats = [
        ChatTypes::DOCTOR_PRIVATE_CONSULTATION => 'site\frontend\modules\chat\components\chats\PrivateDoctorConsultationChat',
    ];

    /**
     * @param int $type
     * @param array $participants
     *
     * @throws \Exception
     *
     * @return \site\frontend\modules\chat\models\Chat
     */
    public static function createChat($type, $participants)
    {
        if (!array_key_exists($type, self::$chats)) {
            throw new \Exception('NotSupportedChatType');;
        }

        /**
         * @var IChat $chat
         */
        $chat = new self::$chats[$type]();

        return $chat->onCreate($participants);
    }

    /**
     * @param int $chatId
     * @param string $message
     */
    public static function addMessageToChat($chatId, $message)
    {

    }

    /**
     * @param \User[] $users
     * @param \site\frontend\modules\chat\models\Chat $chat
     */
    public static function attachParticipants($users, $chat)
    {
        foreach ($users as $user) {
            $userInChat = new UsersChats();

            $userInChat->user_id = $user->id;
            $userInChat->chat_id = $chat->id;

            $userInChat->save();
        }
    }
}