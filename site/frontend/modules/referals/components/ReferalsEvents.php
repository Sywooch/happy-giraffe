<?php

namespace site\frontend\modules\referals\components;

class ReferalsEvents
{
    const INVITE_TO_CONTEST = 0;

    public static $events = array(
        'InviteToContest' => self::INVITE_TO_CONTEST,
    );
}