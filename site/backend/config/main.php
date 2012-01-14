<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Админка',

	'import'=>array(
		'site.common.models.*',
		'application.models.*',
		'application.components.*',
        'site.frontend.modules.attribute.models.*',
	),
	
	'components' => array(
		'urlManager' => array(
			'urlFormat'=>'path',
		),
	),
);