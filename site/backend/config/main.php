<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Админка',

	'import'=>array(
		'site.common.models.*',
		'application.models.*',
		'application.components.*',
	),
	
	'components' => array(
		'urlManager' => array(
			'urlFormat'=>'path',
		),
	),
);