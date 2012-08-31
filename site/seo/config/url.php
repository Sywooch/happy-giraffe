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
        'keywords' => 'writing/editor/index',
        'tasks' => 'writing/editor/tasks',
        'competitors/' => 'competitors/default/index',

        'commentators/user/<user_id:[\d]+>/<period:[\w-]+>'=>'commentators/default/commentator',
        'commentators/user/<user_id:[\d]+>'=>'commentators/default/commentator',
        'commentators/<period:[\w-]+>/<day:\d+>'=>'commentators/default/index',
        'commentators/<period:[\w-]+>'=>'commentators/default/index',
        'commentators'=>'commentators/default/index',
    ),
);