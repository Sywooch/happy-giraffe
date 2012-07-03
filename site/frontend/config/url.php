<?php

return array(
    'class' => 'HUrlManager',
    'urlFormat'=>'path',
    'showScriptName' => false,
    'urlSuffix' => '/',
    'useStrictParsing' => true,
    'rules' => array(
        'activity' => 'activity/index',

        '/user/<user_id:\d+>' => 'user/profile',
        '/user/<user_id:\d+>/clubs' => 'user/clubs',
        '/user/<user_id:\d+>/friends' => 'user/friends',
        '/user/<user_id:\d+>/blog/rubric<rubric_id:\d+>' => 'blog/list',
        '/user/<user_id:\d+>/blog' => 'blog/list',
        '/user/<user_id:\d+>/blog/post<content_id:\d+>' => 'blog/view',
        '/user/<id:\d+>/albums' => 'albums/user',
        '/user/<user_id:\d+>/albums/<id:\d+>' => 'albums/view',
        '/user/<user_id:\d+>/albums/<album_id:\d+>/photo<id:\d+>' => 'albums/photo',
        '/user/<user_id:\d+>/rss/page/<page:\d+>' => 'rss/user',
        '/user/<user_id:\d+>/rss' => 'rss/user',
        '/user/<user_id:\d+>/comments/rss/page/<page:\d+>' => 'rss/comments',
        '/user/<user_id:\d+>/comments/rss' => 'rss/comments',

        'user/blog/add' => 'community/add/community_id/999999/content_type_slug/post/blog/1/',
        'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>/<content_type_slug:\w+>' => 'community/list',
        'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>' => 'community/list',
        'community/<community_id:\d+>/forum' => 'community/list',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
        'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>/uploadImage' => 'community/uploadImage',
        'community/22' => 'cook',
        '^community/list' => 404,

        'contest/<id:\d+>' => 'contest/default/view',
        'contest/<id:\d+>/rules' => 'contest/default/rules',
        'contest/<id:\d+>/list/<sort:\w+>' => 'contest/default/list',
        'contest/<id:\d+>/list' => 'contest/default/list',
        'contest/<id:\d+>/results' => 'contest/default/results',
        'contest/work/<id:\d+>' => 'contest/default/work',
        'contest/<action:\w+>/<id:\d+>' => 'contest/default/<action>',

        'morning/saveLocation' => 'morning/saveLocation',
        'morning/<id:\d+>' => 'morning/view',
        'morning/<date:[\d\d\d\d-\d\d-\d\d]*>' => 'morning/index',
        'morning/' => 'morning/index',
        'morning/index/<date:[\w-]+>'=>'404',
        'morning/index/'=>'404',

        '/' => 'site/index',
        'admin/' => 'admin/site/index',
        '<controller:\w+>/admin'=>'site/index',
        '<controller:\w+>/master'=>'<controller>/admin',
        '<controller:\w+>/<title:\w+>_<id:\d+>/photo<pid:\d+>'=>'<controller>/view',
        '<controller:\w+>/<title:\w+>_<id:\d+>'=>'<controller>/view',
        'babySex/<action:\w+>'=>'services/babySex/default/<action>',
        'sewing/<action:\w+>'=>'services/sewing/default/<action>',
        'sewing/default/<action:\w+>'=>'services/sewing/default/<action>',
        'sizes/<action:\w+>'=>'services/sizes/default/<action>',
        'test/'=>'services/test/default/index',
        'test/<slug:[\w-]+>'=>'services/test/default/view',
        'im/<action:[\w-]+>'=>'im/default/<action>',
        'geo/<action:[\w-]+>'=>'geo/geo/<action>',

        'tester/'=>'services/tester/default/index',
        'tester/<slug:[\w-]+>'=>'services/tester/default/view',

        'names/'=>'services/names/default/index',
        'names/top10'=>'services/names/default/top10',
        'names/saint/<m:[\w]+>'=>'services/names/default/saint',
        'names/saint'=>'services/names/default/saint',
        'names/saintCalc'=>'services/names/default/saintCalc',
        'names/likes'=>'services/names/default/likes',
        'names/like'=>'services/names/default/like',
        'names/CreateFamous'=>'services/names/default/CreateFamous',
        'names/<name:[\w]+>'=>'services/names/default/name/',

        'childrenDiseases/'=>'services/childrenDiseases/default/index',
        'childrenDiseases/<id:[\w-+\s]+>'=>'services/childrenDiseases/default/view',

//        'recipeBook/disease/<url:\w+>'=>'recipeBook/default/disease',
//        'recipeBook/view/<id:\d+>'=>'recipeBook/default/view',
        //'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        'shop' => array('product/view', 'defaultParams' => array('title' => 'Jetem_Turbo_4S', 'id' => 10)),
//		'<controller:\w+>/<action:\w+>' => '<controller>/<action>',

        'horoscope/'=>'services/horoscope/default/index',
        'horoscope/year/<zodiac:[\w]+>'=>'services/horoscope/default/year',
        'horoscope/month/<zodiac:[\w]+>'=>'services/horoscope/default/month',
        'horoscope/<zodiac:[\w]+>/<date:[\d\d\d\d-\d\d-\d\d]*>'=>'services/horoscope/default/view',
        'horoscope/today/<zodiac:[\w]+>'=>'services/horoscope/default/view',
        'horoscope/tomorrow/<zodiac:[\w]+>'=>'services/horoscope/default/tomorrow',
        'horoscope/yesterday/<zodiac:[\w]+>'=>'services/horoscope/default/yesterday',

        'cook/spices/index' => 'cook/spices/index',
        'cook/spices/category/<id:[\w_]+>' => 'cook/spices/category',
        'cook/spices/<id:[\w_]+>' => 'cook/spices/view',

        'cook/choose/index' => 'cook/choose/index',
        'cook/choose/category/<id:[\w_]+>' => 'cook/choose/category',
        'cook/choose/<id:[\w_]+>' => 'cook/choose/view',
        'cook/decor/<id:[\d]+>' => 'cook/decor/index',
        'cook/decor/<id:[\d]+>/<photo:[\w_]+>' => 'cook/decor/index',
        'cook/decor/<photo:[\w_]+>' => 'cook/decor/index',

        'cook/decor/<id:[\d]+>/page/<page:[\d]+>/<photo:[\w_]+>' => 'cook/decor/index',
        'cook/decor/<id:[\d]+>/page/<page:[\d]+>' => 'cook/decor/index',
        'cook/decor/page/<page:[\d]+>/<photo:[\w_]+>' => 'cook/decor/index',
        'cook/decor/page/<page:[\d]+>' => 'cook/decor/index',
        'cook/decor' => 'cook/decor/index',

        'cook/recipe/add' => 'cook/recipe/form',
        'cook/recipe/edit/<id:\d+>' => 'cook/recipe/form',
        'cook/recipe/<id:\d+>' => 'cook/recipe/view',
        'cook/recipe/type/<type:\d+>' => 'cook/recipe/index',

        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

        'pregnancyWeight' => 'services/pregnancyWeight/default/index',
        'contractionsTime' => 'services/contractionsTime/default/index',
        'placentaThickness' => 'services/placentaThickness/default/index',
        'vaccineCalendar' => 'services/vaccineCalendar/default/index',
        'menstrualCycle' => 'services/menstrualCycle/default/index',
        'babyBloodGroup' => 'services/babyBloodGroup/default/index',
        'hospitalBag' => 'services/hospitalBag/default/index',
        //'recipeBook/view/<id:\d+>' => 'services/recipeBook/default/view',
        'recipeBook' => 'services/recipeBook/default/index',
        'recipeBook/getAlphabetList'=>'services/recipeBook/default/getAlphabetList',
        'recipeBook/getCategoryList'=>'services/recipeBook/default/getCategoryList',
        'recipeBook/<url:\w+>' => 'services/recipeBook/default/disease',
        'maternityLeave' => 'services/maternityLeave/default/index',
        'repair/<controller:[\w-]+>'=>'services/repair/<controller>/index',

        'signal' => 'signal/default/index',
        'score' => 'scores/default/index',
        '/contest' => '/site/contest',
        'search' => 'site/search',

        array('class'=>'ext.sitemapgenerator.SGUrlRule', 'route'=>'/sitemap'),

        'js_dynamics/<hash:\w+>.js' => 'site/seoHide',
    ),
);