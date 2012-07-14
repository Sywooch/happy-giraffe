<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'id' => 'happy-giraffe',
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Клуб',
	'homeUrl' => 'http://www.happy-giraffe.ru',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
        'site.common.components.*',
		'site.common.models.*',
        'site.common.models.mongo.*',
        'site.common.models.interest.*',
        'site.common.models.*',
        'site.common.helpers.*',
		'ext.ufile.UFiles',
		'application.models.*',
		'application.components.*',
		'application.helpers.*',
        'application.widgets.*',
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
		'ext.CAdvancedArBehavior',
		'ext.EGMap.*',
        'ext.YiiMongoDbSuite.*',
		'application.modules.vaccineCalendar.models.*',
	    'application.modules.hospitalBag.models.*',
        'application.modules.placentaThickness.models.*',
	    'application.modules.recipeBook.models.*',
        'application.modules.names.models.*',
        'application.modules.test.models.*',
        'application.modules.attribute.models.*',
        'application.modules.im.models.*',
        'application.modules.im.components.*',
        'application.modules.geo.models.*',
        'application.modules.scores.models.*',
	),

	'sourceLanguage' => 'en',
	'language' => 'ru',

    /* Техническое обслуживание */
    /*'catchAllRequest' => (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '88.87.70.93', '178.35.209.102', '91.205.122.228')))?null:array(
        '/site/maintenance',
    ),*/

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
        'im',
        'geo',
        'signal',
        'scores',
        'services',
        'cook'
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
				'CKEditorWidget' => array(
					'ckEditor' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www' . DIRECTORY_SEPARATOR . 'ckeditor' . DIRECTORY_SEPARATOR . 'ckeditor.php',
				),
			),
		),
		'search' => array(
		    'class' => 'site.frontend.extensions.DGSphinxSearch.DGSphinxSearch',
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
					'client_id' => '2855330',
					'client_secret' => 'T9pHwkodkssoEjswy2fw',
				),
                'facebook' => array(
                    'class' => 'CustomFacebookService',
                    'client_id' => '412497558776154',
                    'client_secret' => 'dc98234daa8c7a0d943a92423793590d',
                ),
				'mailru' => array(
					'class' => 'CustomMailruService',
					'client_id' => '667969',
					'client_secret' => '3a0e2674098641394a8e5e0b4328e594',
				),
/*                'google' => array(
                    'class' => 'CustomGoogleService',
                    'client_id' => '999100941078.apps.googleusercontent.com',
                    'client_secret' => '6fDvpI0FO0lmhdDTMCl-I8gD',
                ),
                'twitter' => array(
                    'class' => 'CustomTwitterService',
                    'key' => '19JgB2MpN6VgOVBrR1zrqQ',
                    'secret' => 'lIVhQhUeKV9TYRH2DFT70Bxu5EIlqipTM8uD0nw',
                ),*/
                'odnoklassniki' => array(
                    'class' => 'CustomOdnoklassnikiService',
                    'client_id' => '90353152',
                    'client_secret' => '4D9D33E5CD84A7F203BBC8C7',
                    'client_public' => 'CBAPKDGGABABABABA',
                    'title' => 'Odnokl.',
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
			'loginUrl'=>'/',
		),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'auth__items',
            'itemChildTable'=>'auth__items_childs',
            'assignmentTable'=>'auth__assignments',
			'defaultRoles' => array('user'),
		),
		'urlManager'=>require_once(dirname(__FILE__).'/url.php'),
		'db' => array(
            'schemaCachingDuration' => 180,
            'tablePrefix'=> '',
        ),
        'db_seo' => array(
            'class'=>'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=happy_giraffe_seo',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 60,
        ),
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
//				array(
//					'class'=>'CEmailLogRoute',
//					'levels'=>'error, warning',
//					'emails'=>'choojoy.work@gmail.com',
//				),
//				array(
//					'class'=>'CWebLogRoute',
//					'categories'=>'system.db.CDbCommand',
//					'showInFireBug'=>false,
//				),

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
        'mongodb' => array(
            'class'            => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName'           => 'happy_giraffe_db',
            'fsyncFlag'        => true,
            'safeFlag'         => true,
            'useCursor'        => false
        ),
        'comet'=>array(
            'class' => 'ext.Dklab_Realplexor',
            'host' => 'plexor.www.happy-giraffe.ru',
            'port' => 10010,
            'namespace' => 'crm_',
        ),
        'mc' => array(
            'class' => 'site.common.extensions.mailchimp.MailChimp',
            'apiKey' => '761494406f3754b8128246285e00b703-us5',
            'list' => '5772c2a539'
        )
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
        'gaPass'=>'',
        'gaCode' => 'UA-27545132-1',
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
        'frontend_url'=>'http://www.happy-giraffe.ru/',
        'yandex_map_key'=>'APNWO08BAAAAW2vMcQMAZXlfPtec2tbfe7OW5EsxvDs1as4AAAAAAAAAAACnuPxeb0WX5vAOrlYnXZpmrsJVtA==',
        'google_map_key'=>'AIzaSyCk--cFAYpjqqxmbabeV9IIlwbmnYlzHfc'
	),

        'controllerMap' => array(
            'sitemap' => array(
                'class' => 'ext.sitemapgenerator.SGController',
                'config' => array(
                    'sitemap.xml' => array(
                        'aliases' => array(
                            'application.controllers',
                            'application.modules.cook.controllers.RecipeController',
                            'application.modules.services.modules.pregnancyWeight.controllers',
                            'application.modules.services.modules.contractionsTime.controllers',
                            'application.modules.services.modules.placentaThickness.controllers',
                            'application.modules.services.modules.vaccineCalendar.controllers',
                            'application.modules.services.modules.menstrualCycle.controllers',
                            'application.modules.services.modules.babyBloodGroup.controllers',
                            'application.modules.services.modules.repair.controllers',
                            'application.modules.services.modules.horoscope.controllers',
                            'application.modules.services.modules.test.controllers',
                        ),
                    ),
                ),
            ),
        ),

);
