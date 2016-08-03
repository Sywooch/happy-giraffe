<?php

namespace site\frontend\modules\referals\components;

use site\frontend\modules\referals\components\handlers\Handler;
use site\frontend\modules\referals\models\UserRefLink;

class ReferalsManager
{
    private static $events = array(
        ReferalsEvents::INVITE_TO_CONTEST => 'site\frontend\modules\referals\components\handlers\InviteToContestHandler',
    );

    /**
     * @param UserRefLink $ref
     *
     * @throws \HttpException
     *
     * @return string
     */
    public static function handleRef($ref)
    {
        if (!array_key_exists($ref->event, self::$events)) {
            throw new \HttpException('RefEventNotFound', 404);
        }

        $handler = new self::$events[$ref->event]();

        if (!($handler instanceof Handler)) {
            throw new \HttpException('InvalidHandler', 500);
        }

        return $handler->handle($ref);
    }

    /**
     * @param int $event
     *
     * @return bool
     */
    public static function validateEvent($event)
    {
        return in_array($event, self::$events);
    }
}