<?php

namespace site\frontend\modules\v1\helpers;

/**
 * Format some model fields before post processing.
 * May be replace IPostProcessable in future.
 */
class Formatter
{
    /**@todo: change to format classes list */
    private static $rules = array(
        'User' => 'formatUser',
    );

    public static function format(&$model)
    {
        if (!is_object($model)) {
            return;
        }

        $class = get_class($model);

        if (isset(self::$rules[$class])) {
            $method = self::$rules[$class];
            call_user_func(array(Formatter::class, $method), $model);
        }
    }

    public static function formatUser(&$model)
    {
        if ($model->avatarInfo == '') {
            $model->avatarInfo = null;

            if ($model->avatar_id) {
                $model->avatarInfo = //\CJSON::encode(
                    array(
                        'small' => $model->getAvatarUrl(24),
                        'medium' => $model->getAvatarUrl(40),
                        'big' => $model->getAvatarUrl(72),
                        //)
                    );
            }
        } else {
            $model->avatarInfo =  \CJSON::decode($model->avatarInfo);
        }
    }
}