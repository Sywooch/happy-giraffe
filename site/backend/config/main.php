<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Админка',

	'import'=>array(
        'site.frontend.extensions.ufile.UFileBehavior',
		'site.common.models.*',
		'application.models.*',
		'application.components.*',
        'site.frontend.modules.attribute.models.*',
	),
	
	'components' => array(
		'urlManager' => array(
			'urlFormat'=>'path',
		),
        'db' => array(
            'schemaCachingDuration' => 3600,
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix'=> '',
        ),
	),
);