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
        'writing/keywords' => 'writing/editor/index',
        'writing/tasks' => 'writing/editor/tasks',
        'competitors' => array('competitors/default/index', 'defaultParams' => array('section' => 1)),
        'competitors/cook' => array('competitors/default/index', 'defaultParams' => array('section' => 2)),

        'commentators/clubs' => 'commentators/default/clubs',
        'commentators/user/<user_id:[\d]+>/<period:[\w-]+>' => 'commentators/default/commentator',
        'commentators/user/<user_id:[\d]+>' => 'commentators/default/commentator',
        'commentators/<period:[\w-]+>/<day:\d+>' => 'commentators/default/index',
        'commentators/<period:[\w-]+>' => 'commentators/default/index',
        'commentators' => 'commentators/default/index',

        'cook/recipe/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 0)),
        'cook/multivarka/<id:\d+>' => array('cook/recipe/view', 'defaultParams' => array('section' => 1)),

        'externalLinks/sites/reports/<page:[\d]+>' => 'externalLinks/sites/reports',

        'cook' => array('cook/editor/index', 'defaultParams' => array('section' => 2)),
        'cook/tasks' => array('cook/editor/tasks', 'defaultParams' => array('section' => 2)),
        'cook/reports' => array('cook/editor/reports', 'defaultParams' => array('section' => 2)),
        'cook/name' => array('cook/editor/name', 'defaultParams' => array('section' => 2)),

        'needlework' => array('cook/editor/index', 'defaultParams' => array('section' => 3)),
        'needlework/tasks' => array('cook/editor/tasks', 'defaultParams' => array('section' => 3)),
        'needlework/reports' => array('cook/editor/reports', 'defaultParams' => array('section' => 3)),
        'needlework/name' => array('cook/editor/name', 'defaultParams' => array('section' => 3)),

        'design' => array('cook/editor/index', 'defaultParams' => array('section' => 4)),
        'design/tasks' => array('cook/editor/tasks', 'defaultParams' => array('section' => 4)),
        'design/reports' => array('cook/editor/reports', 'defaultParams' => array('section' => 4)),
        'design/name' => array('cook/editor/name', 'defaultParams' => array('section' => 4)),
    ),
);