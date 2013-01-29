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
        'application.modules.attribute.models.*',
        'application.modules.im.models.*',
        'application.modules.im.components.*',
        'application.modules.geo.models.*',
        'application.modules.scores.models.*',
        'application.modules.calendar.models.*',
        'application.modules.cook.models.*',
        'application.modules.contest.models.*',
        'application.modules.whatsNew.models.*',
        'application.modules.whatsNew.components.*',
        'application.modules.whatsNew.widgets.whatsNewWidget.WhatsNewWidget',
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
        'cook',
        'calendar',
        'whatsNew',
	),

	// application components
	'components'=>array(
        'clientScript' => array(
//            'scriptMap'=>array(
//                'jquery'=>'http://code.jquery.com/jquery-1.8.0.min.js',
//            ),
            'packages' => array(
                'comet' => array(
                    'baseUrl' => '/',
                    'js' => array(
                        'javascripts/comet.js',
                        'javascripts/dklab_realplexor.js',
                    ),
                ),
                'user' => array(
                    'baseUrl' => '/',
                    'js' => array(
                        'javascripts/user_common.js',
                        'javascripts/messages.js',
                        'javascripts/friends.js',
                        'javascripts/notifications.js',
                        'javascripts/settings.js',
                        'javascripts/wantToChat.js',
                    ),
                    'depends' => array('comet'),
                )
            ),
        ),
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
            'cache' => false,
			'services' => array( // You can change the providers and their classes.
                'mailru' => array(
                    'class' => 'CustomMailruService',
                    'client_id' => '667969',
                    'client_secret' => '3a0e2674098641394a8e5e0b4328e594',
                ),
                'odnoklassniki' => array(
                    'class' => 'CustomOdnoklassnikiService',
                    'client_id' => '93721600',
                    'client_secret' => '4E774EFE678A1ECF3D4625F3',
                    'client_public' => 'CBAFBHJGABABABABA',
                    'title' => 'Odnokl.',
                ),
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
                /*'google' => array(
                    'class' => 'CustomGoogleService',
                    'client_id' => '999100941078.apps.googleusercontent.com',
                    'client_secret' => '6fDvpI0FO0lmhdDTMCl-I8gD',
                ),*/
                'twitter' => array(
                    'class' => 'CustomTwitterService',
                    'key' => '9NY9gDqPgU2DMIYrEv2pCA',
                    'secret' => '2Lk4Q34fINqSrx5BlpKz6qtyCsofI3M9FHRYCElceE',
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
            'schemaCachingDuration' => 3600,
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
//                array(
//                    'class' => 'CProfileLogRoute',
//                ),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
//                array(
//                    'class'=>'CEmailLogRoute',
//                    'levels'=>'error, warning',
//                    'emails'=>'nikita@happy-giraffe.ru',
//                ),
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
        'mongodb_production' => array(
            'class' => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName' => 'happy_giraffe_production',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false
        ),
        'comet'=>array(
            'class' => 'ext.Dklab_Realplexor',
            'host' => 'plexor.www.happy-giraffe.ru',
            'port' => 10010,
            'namespace' => 'crm_',
        ),
        'mc' => array(
            'class' => 'site.common.extensions.mailchimp.MailChimp',
            'apiKey' => 'c0ff51b36480912260a410258b64af5f-us5',
            'list' => 'd8ced52317'
        ),
        'mandrill' => array(
            'class' => 'site.common.components.Mandrill',
            'apiKey' => '1f816ac2-65b7-4a28-90c9-7e8fb1669d43',
        ),
        'email'=>array(
            'class' => 'site.common.components.HEmailSender',
        ),
        'geoCode'=>array(
            'class' => 'site.frontend.modules.geo.components.GoogleMapsGeoCode',
        ),
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
        'google_map_key'=>'AIzaSyCk--cFAYpjqqxmbabeV9IIlwbmnYlzHfc',
        'combineMap' => array(
            '/javascripts/all.js' => array(
                'jquery.min.js',
                'jquery.yiiactiveform.js',
                'jquery.ba-bbq.js',
                'jquery.fancybox-1.3.4.js',
                'jquery.iframe-post-form.js',
                'jquery.placeholder.min.js',
                'chosen.jquery.min.js',
                'checkbox.js',
                'common.js',
                'base64.js',
                'jquery.tooltip.pack.js',
                'jquery.dataSelector.js',
                'jquery.jcarousel.js',
                'jquery.jcarousel.control.js',
                'jquery.tmpl.min.js',
                'login.js',
                'auth.js',
                'jquery.yiilistview.js',
                'addtocopy.js',
            ),
            '/javascripts/all_user.js' => array(
                'comet.js',
                'dklab_realplexor.js',
                'user_common.js',
                'messages.js',
                'friends.js',
                'notifications.js',
                'settings.js',
                'wantToChat.js',
            ),
            /*'/stylesheets/all.css' => array(
                'baby.css',
                'common.css',
                'global.css',
                'jquery.fancybox-1.3.4.css',
                'user.css',
                'auth.css',
            ),*/
        ),
	),

        'controllerMap' => array(
            'sitemap' => array(
                'class' => 'ext.sitemapgenerator.SGController',
                'config' => array(
                    'sitemap.xml' => array(
                        'index' => true,
                    ),
                    'sitemapCommunity.xml' => array(
                        'aliases' => array(
                            'application.controllers.CommunityController',
                        ),
                    ),
                    'sitemapBlog.xml' => array(
                        'aliases' => array(
                            'application.controllers.BlogController',

                        ),
                    ),
                    'sitemapCook.xml' => array(
                        'aliases' => array(
                            'application.modules.cook.controllers.SpicesController',
                            'application.modules.cook.controllers.ChooseController',
                            'application.modules.cook.controllers.RecipeController',
                        ),
                    ),
                    'sitemapAll.xml' => array(
                        'aliases' => array(
                            'application.controllers.SiteController',
                            'application.modules.services.modules.recipeBook.controllers.DefaultController',
                            'application.modules.services.modules.names.controllers.DefaultController',
                            'application.modules.services.modules.childrenDiseases.controllers.DefaultController',
                            'application.modules.calendar.controllers.DefaultController',
                            'application.modules.services.modules.pregnancyWeight.controllers.DefaultController',
                            'application.modules.services.modules.contractionsTime.controllers.DefaultController',
                            'application.modules.services.modules.placentaThickness.controllers.DefaultController',
                            'application.modules.services.modules.vaccineCalendar.controllers.DefaultController',
                            'application.modules.services.modules.menstrualCycle.controllers.DefaultController',
                            'application.modules.services.modules.babyBloodGroup.controllers.DefaultController',
                            'application.modules.services.modules.horoscope.controllers.DefaultController',
                            'application.modules.services.modules.horoscope.controllers.CompatibilityController',
                        ),
                    ),
                ),
            ),
        ),

);
