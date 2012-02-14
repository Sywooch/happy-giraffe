<?php

return array(
	'urlFormat'=>'path',
	'showScriptName' => false,
	'urlSuffix' => '/',
	'rules' => array(
		'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>/<content_type_slug:\w+>' => 'community/list',
		'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/list',
		'community/<community_id:\d+>/forum/<content_type_slug:\w+>' => 'community/list',
		'community/<community_id:\d+>/forum' => 'community/list',
		'community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
	
		'contest/<id:\d+>' => 'contest/contest/view',
		'contest/work/<id:\d+>' => 'contest/contestWork/view',
		'contest/list/<id:\d+>/<sort:\w+>' => 'contest/contest/list',
		'contest/<action:\w+>/<id:\d+>' => 'contest/contest/<action>',
		
		'/' => 'site/index',
		'admin/' => 'admin/site/index',
		'<controller:\w+>/admin'=>'site/index',
		'<controller:\w+>/master'=>'<controller>/admin',
		'<controller:\w+>/<title:\w+>_<id:\d+>'=>'<controller>/view',
		'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'babySex/<action:\w+>'=>'babySex/default/<action>',
        'names/<action:\w+>'=>'names/default/<action>',
        'sewing/<action:\w+>'=>'sewing/default/<action>',
        'sizes/<action:\w+>'=>'sizes/default/<action>',
        'test/<slug:[\w-]+>'=>'test/default/view',
        'im/<action:[\w-]+>'=>'im/default/<action>',
        'geo/<action:[\w-]+>'=>'geo/geo/<action>',
//        'recipeBook/disease/<url:\w+>'=>'recipeBook/default/disease',
//        'recipeBook/view/<id:\d+>'=>'recipeBook/default/view',
		//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		'shop' => array('product/view', 'defaultParams' => array('title' => 'Jetem_Turbo_4S', 'id' => 10)),
//		'<controller:\w+>/<action:\w+>' => '<controller>/<action>',

		array('class'=>'ext.sitemapgenerator.SGUrlRule', 'route'=>'/sitemap'),

	),
);

