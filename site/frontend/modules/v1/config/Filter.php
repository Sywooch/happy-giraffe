<?php

namespace site\frontend\modules\v1\config;

class Filter {
    private static $ignoredFields = array(
        'User' => array(
            'password',
        ),
    );

    public static function getFilter($attributes, $class) {
        if (!isset(self::$ignoredFields[$class])) {
            return true;
        }

        $filter = array();

        foreach ($attributes as $attribute => $value) {
            if (!in_array($attribute, self::$ignoredFields[$class])) {
                array_push($filter, $attribute);
            }
        }

        return $filter;
    }
}