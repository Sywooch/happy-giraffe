<?php

namespace site\frontend\modules\chat\components\chats;

use site\frontend\modules\chat\components\ChatManager;
use site\frontend\modules\chat\components\IChat;
use site\frontend\modules\chat\models\Chat;
use site\frontend\modules\chat\models\ChatMessage;
use site\frontend\modules\chat\values\ChatTypes;
use site\frontend\modules\specialists\models\SpecialistGroup;

class PrivateDoctorConsultationChat implements IChat
{
    /**
     * @param array $participants
     *
     * @throws \Exception
     *
     * @return \site\frontend\modules\chat\models\Chat
     */
    public function onCreate($participants)
    {
        if (count($participants) != 2) {
            throw new \Exception('RequireOnlyTwoParticipants');
        }

        $doctorsCount = 0;

        /**@var \User[] $users*/
        $users = [];

        foreach ($participants as $id) {
            /**@var \User $user*/
            $user = \User::model()->findByPk($id);

            if ($user == null) {
                throw new \Exception('InvalidParticipant');
            }

            if ($user->isSpecialistOfGroup(SpecialistGroup::DOCTORS)) {
                $doctorsCount++;
            }

            $users[] = $user;
        }

        if ($doctorsCount != 1) {
            throw new \Exception('RequireOnlyOneDoctor');
        }


        try {
            $chat = new Chat();

            $chat->type = ChatTypes::DOCTOR_PRIVATE_CONSULTATION;
            $chat->expires_in = strtotime("+30 minutes");
            $chat->limit = 0;

            $chat->save();

            ChatManager::attachParticipants($users, $chat);

            return $chat;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param \site\frontend\modules\chat\models\Chat $chat
     * @param string $message
     * @param int $userId
     *
     * @return \site\frontend\modules\chat\models\ChatMessage
     */
    public function onMessage($chat, $message, $userId)
    {
        if (($chat->expires_in == null && $chat->limit <= 0) || $chat->expires_in <= time()) {
            return false;
        }

        $chatMessage = ChatMessage::create($message, $chat->id, $userId);

        return $chatMessage;
    }
}