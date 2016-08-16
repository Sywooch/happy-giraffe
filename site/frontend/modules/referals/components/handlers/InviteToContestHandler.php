<?php

namespace site\frontend\modules\referals\components\handlers;

use site\frontend\modules\comments\modules\contest\components\ContestManager;
use site\frontend\modules\comments\modules\contest\models\CommentatorsContestParticipant;

class InviteToContestHandler extends Handler
{
    protected function continueHandle()
    {
        if ($this->getVisitor()->isNewRecord) {
            /**
             * @var \User $user
             */
            $user = \User::model()->findByPk($this->getRef()->user_id);

            if (!$user) {
                throw new \HttpException('UserForThisRefNotFound', 404);
            }

            //later
            /**
             * @var CommentatorsContestParticipant $participant
             */
//            $participant = CommentatorsContestParticipant::model()
//                ->byUser($user->id)
//                ->byContest(ContestManager::getCurrentActive()->id)
//                ->find();
//
//            $participant->score += 5;
//
//            $participant->update(array('score'));
        }

        return \Yii::app()->createUrl('/comments/contest/default/index');
    }
}