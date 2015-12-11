<?php

namespace site\frontend\modules\v1\config;

class Filter {
    private static $ignoredFields = array(
        'User' => array(
            'password',
        ),
    );

    private static $ignoredRelations = array(
        'User' => array(
            'comments',
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

    public static function filterWithParameters($with, $class) {
        if (!isset(self::$ignoredRelations[$class])) {
            return $with;
        }

        $temp = array();

        foreach ($with as $w) {
            if (!in_array($w, self::$ignoredRelations[$class])) {
                array_push($temp, $w);
            }
        }

        return $temp;
    }
}