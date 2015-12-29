<?php

namespace site\frontend\modules\v1\config;

/**
 * Represents filter methods for AR and relations.
 */
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
            'comments',
        ),
        'AlbumPhoto' => array(
            'created',
            'updated',
        ),
        'site\frontend\modules\v1\models\UserApiToken' => array(
            'error',
            '_id',
        ),
    );

    private static $ignoredRelations = array(
        'User' => array(
            'comments',
            'avatar',
            'babies',
            'realBabies',
            'socialServices',
            'communities',
            'menstrualUserCycle',
            'UserCaches',
            'Messages',
            'dialogUsers',
            'names',
            'recipeBookRecipes',
            'userPointsHistories',
            'userSocialServices',
            'commentsCount',
            'activeCommentsCount',
            'purpose',
            'albums',
            'privateAlbum',
            'simpleAlbums',
            'interests',
            'mood',
            'partner',
            'blog_rubrics',
            'address',
            'priority',
            'recipes',
            'answers',
            'activeQuestion',
            'photos',
            'mail_subs',
            'score',
            'awards',
            'achievements',
            'friendLists',
            'subscriber',
            'clubSubscriber',
            'clubSubscriptions',
            'clubSubscriptionsCount',
            'blogPhoto',
            'specializations',
            'communityPosts',
            'spamStatus',
        ),
        'site\frontend\modules\comments\models\Comment' => array(
            'response',
        ),
        'site\frontend\modules\posts\models\Content' => array(
            'labelModels',
            'tagModels',
            'communityContent',
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