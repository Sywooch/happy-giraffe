<?php

return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'rules' => array(
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
        'user/<user_id:\d+>/blog/post<content_id:\d+>' => 'blog/view',

        'login' => 'site/login',
        'logout' => 'site/logout',
        'keywords' => 'writing/editor/index',
        'tasks' => 'writing/editor/tasks',
        'competitors' => array('competitors/default/index', 'defaultParams' => array('section' => 1)),
        'competitors/cook' => array('competitors/default/index', 'defaultParams' => array('section' => 2)),

        'commentators/clubs'=>'commentators/default/clubs',
        'commentators/user/<user_id:[\d]+>/<period:[\w-]+>'=>'commentators/default/commentator',
        'commentators/user/<user_id:[\d]+>'=>'commentators/default/commentator',
        'commentators/<period:[\w-]+>/<day:\d+>'=>'commentators/default/index',
        'commentators/<period:[\w-]+>'=>'commentators/default/index',
        'commentators'=>'commentators/default/index',

        'cook/recipe/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 0)),
        'cook/multivarka/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 1)),
    ),
);