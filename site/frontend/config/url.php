<?php

return array(
	'urlFormat'=>'path',
	'showScriptName' => false,
	'urlSuffix' => '/',
	'rules' => array(
        'user/blog/add' => 'community/add/community_id/999999/content_type_slug/post/blog/1/',
		'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>/<content_type_slug:\w+>' => 'community/list',
		'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/list',
		'community/<community_id:\d+>/forum/<content_type_slug:\w+>' => 'community/list',
		'community/<community_id:\d+>/forum' => 'community/list',
		'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',

		'contest/<id:\d+>' => 'contest/default/view',
        'contest/<id:\d+>/rules' => 'contest/default/rules',
        'contest/<id:\d+>/list/<sort:\w+>' => 'contest/default/list',
        'contest/<id:\d+>/list' => 'contest/default/list',
		'contest/work/<id:\d+>' => 'contest/default/work',
		'contest/<action:\w+>/<id:\d+>' => 'contest/default/<action>',

        'morning/' => 'morning/index',
        'morning/<id:\d+>' => 'morning/view',
        'morning/saveLocation' => 'morning/saveLocation',
        'morning/index/<date:[\w-]+>' => 'morning/index',

		'/' => 'site/index',
		'admin/' => 'admin/site/index',
		'<controller:\w+>/admin'=>'site/index',
		'<controller:\w+>/master'=>'<controller>/admin',
		'<controller:\w+>/<title:\w+>_<id:\d+>'=>'<controller>/view',
		'babySex/<action:\w+>'=>'babySex/default/<action>',
        'sewing/<action:\w+>'=>'sewing/default/<action>',
        'sizes/<action:\w+>'=>'sizes/default/<action>',
        'test/<slug:[\w-]+>'=>'test/default/view',
        'im/<action:[\w-]+>'=>'im/default/<action>',
        'geo/<action:[\w-]+>'=>'geo/geo/<action>',

        'names/'=>'names/default/index',
        'names/top10'=>'names/default/top10',
        'names/saint/<m:[\w]+>'=>'names/default/saint',
        'names/saint'=>'names/default/saint',
        'names/saintCalc'=>'names/default/saintCalc',
        'names/likes'=>'names/default/likes',
        'names/like'=>'names/default/like',
        'names/CreateFamous'=>'names/default/CreateFamous',
        'names/<name:[\w]+>'=>'names/default/name/',

        'childrenDiseases/'=>'childrenDiseases/default/index',
        'childrenDiseases/getAlphabetList'=>'childrenDiseases/default/getAlphabetList',
        'childrenDiseases/getCategoryList'=>'childrenDiseases/default/getCategoryList',
        'childrenDiseases/<url:[\w\d- ]+>'=>'childrenDiseases/default/view',

//        'recipeBook/disease/<url:\w+>'=>'recipeBook/default/disease',
//        'recipeBook/view/<id:\d+>'=>'recipeBook/default/view',
		//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		'shop' => array('product/view', 'defaultParams' => array('title' => 'Jetem_Turbo_4S', 'id' => 10)),
//		'<controller:\w+>/<action:\w+>' => '<controller>/<action>',

        'гороскоп/'=>'horoscope/default/index',
        'гороскоп/на-год/<zodiac:[\w]+>'=>'horoscope/default/year',
        'гороскоп/на-месяц/<zodiac:[\w]+>'=>'horoscope/default/month',
        'гороскоп/<zodiac:[\w]+>/<date:[\w-]+>'=>'horoscope/default/view',
        'гороскоп/на-сегодня/<zodiac:[\w]+>'=>'horoscope/default/view',

        '<controller:\w+>/<id:\d+>'=>'<controller>/view',
        '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',

		'pregnancyWeight' => 'pregnancyWeight/default/index',
        'contractionsTime' => 'contractionsTime/default/index',
        'placentaThickness' => 'placentaThickness/default/index',
        'vaccineCalendar' => 'vaccineCalendar/default/index',
        'menstrualCycle' => 'menstrualCycle/default/index',
        'babyBloodGroup' => 'babyBloodGroup/default/index',

        'signal' => 'signal/default/index',
        'score' => 'scores/default/index',
        'rss' => 'site/rss',
        '/contest' => '/site/contest',
        'search' => 'site/search',

        array('class'=>'ext.sitemapgenerator.SGUrlRule', 'route'=>'/sitemap'),

	),
);

