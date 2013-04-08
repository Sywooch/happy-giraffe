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

        'commentators' => 'commentators/default/index',
        'commentators/<_a>/<user_id:\d+>/<month:[\d][\d][\d][\d]-[\d][\d]>' => 'commentators/default/<_a>',
        'commentators/<_a>/<month:[\d][\d][\d][\d]-[\d][\d]>' => 'commentators/default/<_a>',
        'commentators/<_a>' => 'commentators/default/<_a>',

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

        'best' => 'best/default/index',
        'best/<_a>' => 'best/default/<_a>',
    ),
);