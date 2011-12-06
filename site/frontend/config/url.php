<?php

return array(
	'urlFormat'=>'path',
	'showScriptName' => false,
	'urlSuffix' => '/',
	'rules' => array(
		'community/<community_id:\d+>/forum/post/<content_id:\d+>' => 'community/view',
		'community/<community_id:\d+>/forum/<content_type_slug:\w+>/rubric/<rubric_id:\d+>' => 'community/list',
		'community/<community_id:\d+>/forum/rubric/<rubric_id:\d+>' => 'community/list',
		'community/<community_id:\d+>/forum/<content_type_slug:\w+>' => 'community/list',
		'community/<community_id:\d+>/forum' => 'community/list',
	
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
		//'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		'shop' => array('product/view', 'defaultParams' => array('title' => 'Jetem_Turbo_4S', 'id' => 10)),
//		'<controller:\w+>/<action:\w+>' => '<controller>/<action>', 
	),
);

