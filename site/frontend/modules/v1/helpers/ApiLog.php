<?php

namespace site\frontend\modules\v1\helpers;

class ApiLog
{
    public static function i($message)
    {
        \Yii::log($message, 'info', 'api');
    }

    public static function e($message)
    {
        \Yii::log($message, 'error', 'api');
    }
}