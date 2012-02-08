<?php

defined('YII_PROJECT') or define('YII_PROJECT','shop');

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'id' => 'happy-giraffe',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',
	
	'import'=>array(
        'application.components.*',
        'application.models.*',
        'application.modules.names.models.*',
    ),
	// application components
	'components'=>array(
		'db'=>require_once(dirname(__FILE__).'/db.php'),
		'assetManager'=>require_once(dirname(__FILE__).'/assets.php'),
        //'cache'=>require_once(dirname(__FILE__).'/cache.php'),
	),
);