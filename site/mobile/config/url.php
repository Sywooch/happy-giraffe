<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 2/4/13
 * Time: 5:08 PM
 * To change this template use File | Settings | File Templates.
 */

return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'rules' => array(
        'community/<community_id:\d+>' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
        'community/<content_id:\d+>/comments' => 'community/comments',

        'user/<user_id:\d+>/blog/post<content_id:\d+>' => 'blog/view',
        'user/<user_id:\d+>/community' => array('user/index', 'defaultParams' => array('show' => 'community')),
        'user/<user_id:\d+>/blog' => array('user/index', 'defaultParams' => array('show' => 'blog')),
        'user/<user_id:\d+>' => array('user/index', 'defaultParams' => array('show' => 'all')),

        'cook/recipe/tag/<tag:\d+>/type/<type:\d+>' => array('cook/recipe/tag', 'defaultParams' => array('section' => 0)),
        'cook/recipe/tag/<tag:\d+>' => array('cook/recipe/tag', 'defaultParams' => array('section' => 0)),
        'cook/recipe/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 0)),
        'cook/recipe/type/<type:\d+>' => array('cook/recipe/index', 'defaultParams' => array('section' => 0)),
        'cook/recipe' => array('cook/recipe/index', 'defaultParams' => array('section' => 0)),

        'cook/multivarka/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 1)),
        'cook/multivarka/type/<type:\d+>' => array('cook/recipe/index', 'defaultParams' => array('section' => 1)),
        'cook/multivarka' => array('cook/recipe/index', 'defaultParams' => array('section' => 1)),

        'horoscope' => 'horoscope/index',
        'horoscope/<type:(year|month|tomorrow)>/<zodiac:[\w]+>' => 'horoscope/view',
        'horoscope/<zodiac:[\w]+>' => array('horoscope/view', 'defaultParams' => array('type' => 'today')),

        '' => 'community/index',

        //'(.*)' => 'site/index',
    ),
);