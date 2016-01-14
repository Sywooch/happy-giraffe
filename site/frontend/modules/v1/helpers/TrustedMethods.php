<?php

namespace site\frontend\modules\v1\helpers;

class TrustedMethods
{
    private static $methods = array(
        'getIdeas',
    );

    public static function isTrusted($method)
    {
        return in_array($method, self::$methods);
    }
}