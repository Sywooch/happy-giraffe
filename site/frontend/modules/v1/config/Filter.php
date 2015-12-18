<?php

namespace site\frontend\modules\v1\config;

class Filter
{
    private static $ignoredFields = array(
        'User' => array(
            'password',
            'email',
            'phone',
            'avatar_id',
            'about',
            'last_ip',
            'profile_access',
            'guestbook_access',
            'im_access',
            'profile_check',
            'recovery_disable',
            'remember_code',
            'email_confirmed',
            'main_photo_id',
            'registration_source',
            'registration_finished',
            'activation_code',
            'avatarId',
            'specInfo',
            'blog_title',
            'blog_description',
            'blog_photo_id',
            'blog_photo_position',
            'blog_show_rubrics',
        ),
        'CommunityContent' => array(
            'meta_title',
            'meta_keywords',
            'meta_description',
            'meta_description_auto',
        ),
        'site\frontend\modules\posts\models\Content' => array(
            'originEntity',
            'text',
        ),
    );

    private static $ignoredRelations = array(
        'User' => array(
            'comments',
        ),
    );

    public static function getFilter($attributes, $class)
    {
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

    public static function filterWithParameters($with, $class)
    {
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