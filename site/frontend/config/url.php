<?php

return array(
	'urlFormat'=>'path',
	'showScriptName' => false,
	'urlSuffix' => '/',
	'rules' => array(
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
		'shop' => 'product/view/Jetem_Turbo_4S_10/',
		'club/<controller:\w+>/<action:\w+>' => '<controller>/<action>', 
	),
);

