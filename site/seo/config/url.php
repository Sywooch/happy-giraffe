<?php

return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'rules' => array(
        'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>/<content_type_slug:\w+>' => 'community/list',
        'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>' => 'community/list',
        'community/<community_id:\d+>/forum' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>/uploadImage' => 'community/uploadImage',

        'login' => 'site/login',
        'logout' => 'site/logout',
        'keywords' => 'editor/index',
        'tasks' => 'editor/tasks',
        'competitors/<site_id:\d+>' => 'competitors/default/index'
    ),
);