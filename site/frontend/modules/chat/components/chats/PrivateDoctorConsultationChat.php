<?php

namespace site\frontend\modules\chat\components\chats;

use site\frontend\modules\chat\components\ChatManager;
use site\frontend\modules\chat\components\IChat;
use site\frontend\modules\chat\models\Chat;
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

        /**@var \CDbTransaction $transaction*/
        $transaction = \Yii::app()->db->beginTransaction();

        try {
            $chat = new Chat();

            $chat->type = ChatTypes::DOCTOR_PRIVATE_CONSULTATION;
            $chat->expires_in = strtotime("+30 minutes");
            $chat->limit = 0;

            $chat->save();

            ChatManager::attachParticipants($users, $chat);

            $transaction->commit();

            return $chat;
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
    }

    public function onMessage()
    {
        // TODO: Implement onMessage() method.
    }
}