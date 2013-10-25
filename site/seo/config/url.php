<?php

return array(
    'urlFormat' => 'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'rules' => array(
        'community/<_a:(subscribe)>/' => 'community/default/<_a>',
        'community/<forum_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/default/forum',
        'community/<forum_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/default/view',
        'community/<forum_id:\d+>/forum/' => 'community/default/forum',

        'user/<user_id:\d+>/rss/page<page:\d+>' => 'rss/user',
        'user/<user_id:\d+>/rss' => 'rss/user',
        'user/<user_id:\d+>/comments/rss/page<page:\d+>' => 'rss/comments',
        'user/<user_id:\d+>/comments/rss' => 'rss/comments',
        'user/<user_id:\d+>/albums' => 'gallery/user/index',
        'user/<user_id:\d+>/albums/<album_id:\d+>' => 'gallery/user/view',
        'user/<user_id:\d+>/albums/<album_id:\d+>/photo<id:\d+>' => 'albums/photo',
        'user/<_a:(updateMood|activityAll)>' => 'user/<_a>',
        'user/createRelated/relation/<relation:\w+>/' => 'user/createRelated',
        'user/myFriendRequests/<direction:\w+>/' => 'user/myFriendRequests',

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