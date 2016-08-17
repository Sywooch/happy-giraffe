<?php

namespace site\frontend\modules\referals\components\handlers;

class InviteToContestHandler extends Handler
{
    protected function continueHandle()
    {
        if ($this->getVisitor()->isNewRecord) {
            $user = \User::model()->findByPk($this->getRef()->user_id);

            if (!$user) {
                throw new \HttpException('UserForThisRefNotFound', 404);
            }

            //do something with him ...

            return 'redirect';
        }
    }
}