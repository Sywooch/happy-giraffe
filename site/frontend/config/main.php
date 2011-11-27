<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Клуб',
	'theme'=>'happy_giraffe',
	'homeUrl' => 'http://happy-giraffe.ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'ext.ufile.UFiles',
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
		'ext.eoauth.*',
		'ext.eoauth.lib.*',
		'ext.lightopenid.*',
		'ext.eauth.services.*',
		'ext.eauth.custom_services.*',
		'ext.blocks.*',
		'ext.blocks.blocks.*',
		'ext.shoppingCart.*',
		'ext.Captcha',
		'ext.CaptchaAction',
		'ext.LinkPager',
		'ext.wr.WithRelatedBehavior',
		'ext.ESaveRelatedBehavior',
		'ext.image.Image',
		'application.modules.vaccineCalendar.models.*',
        'application.modules.pregnancyWeight.models.*',
	),

	'sourceLanguage' => 'en',
	'language' => 'ru',

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'zawrube8pe2EbUtrAG',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'ext.gtc',   // Gii Template Collection
				'application.gii',
			),
		),
		'contest',
		'attribute',
		'delivery' => array(
			'class' => 'application.modules.delivery.DeliveryModule',
			'returnUrl' => '/shop/shopCartDelivery',
		),
		'billing' => array(
			'urlNext' => "/site/contact",
			'urlNextUserState' => 'billing_url_next',
			'callbackOrderProceed' => array('Order','callbackOrderProceed'),
			'callbackOrderPaid' => array('Order','callbackOrderPaid'),
		),
		'vaccineCalendar',
        'pregnancyWeight',
        'contractionsTime'
	),

	// application components
	'components'=>array(
		'widgetFactory' => array(
			'widgets' => array(
				'LinkPager' => array(
					'cssFile' => FALSE,
					'header' => '',
					'nextPageLabel' => '',
					'prevPageLabel' => '',
					'maxButtonCount' => 5,
				),
			),
		),
		'search' => array(
		    'class' => 'application.components.DGSphinxSearch',
		    'server' => '127.0.0.1',
		    'port' => 9312,
		    'maxQueryTime' => 3000,
		    'enableProfiling'=>0,
		    'enableResultTrace'=>0,
		    'fieldWeights' => array(
			'name' => 10000,
			'keywords' => 100,
		    ),
		),
		'eauth' => array(
			'class' => 'ext.eauth.EAuth',
			'popup' => true, // Use the popup window instead of redirecting.
			'services' => array( // You can change the providers and their classes.
				'vkontakte' => array(
					'class' => 'CustomVKontakteService',
					'client_id' => '2450198',
					'client_secret' => 'yUpyEwys04uWtVfFVBLp',
				),
				'mailru' => array(
					'class' => 'CustomMailruService',
					'client_id' => '642108',
					'client_secret' => 'f1061f6f1b46c2784ffa55cac268ecb7',
				),
			),
		),
		'format' => array(
			'booleanFormat' => array('Нет', 'Да'),
			'dateFormat' => 'd.m.Y',
			'datetimeFormat' => 'd.m.Y H:i',
			'numberFormat' => array(
				'decimals' => 2,
				'thousandSeparator' => ' ',
				'decimalSeparator' => '.',
			),
		),
		'assetManager'=>require_once(dirname(__FILE__).'/assets.php'),
		'cache'=>require_once(dirname(__FILE__).'/cache.php'),
		'user'=>array(
			// enable cookie-based authentication
			'class'=>'WebUser',
			'allowAutoLogin'=>true,
			'roleAttribute'=>'role',
//			'loginUrl'=>'#login',
		),
		'authManager' => array(
			'class' => 'ext.fileRBAC.PhpAuthManager',
			'defaultRoles' => array('guest'),
		),
		'urlManager'=>require_once(dirname(__FILE__).'/url.php'),
		'db'=>require_once(dirname(__FILE__).'/db.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CWebLogRoute',
					'categories'=>'system.db.CDbCommand',
					'showInFireBug'=>true,
				),

				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'shoppingCart' => array(
			'class' => 'ext.shoppingCart.EShoppingCart',
			'discounts' => array(
				array('class' => 'JirafFrandsDiscount'),
				array('class' => 'JirafDiscount'),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'ufileStorageRoot'=>'temp_upload',
		'social' => array(
			'vk' => array(
				'api_id' => 2450198,
				'secret_key' => 'yUpyEwys04uWtVfFVBLp',
			),
			'mail' => array(
				'api_id' => 642108,
				'private_key' => 'f80cfac7dc87add3be6d6126e2c56b49',
				'secret_key' => '9a33bbf4e3c6c78e1dd6427362b0d040',
			),
		),
	),
);
