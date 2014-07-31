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
		'site.common.models.User',
        'site.common.models.mongo.*',
        'site.common.models.interest.*',
        'site.common.models.*',
        'site.common.helpers.*',
		'ext.ufile.UFiles',
		'application.models.*',
		'application.components.*',
        'application.components.video.*',
		'application.helpers.*',
        'application.widgets.*',
        'application.vendor.*',
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
		'ext.Captcha',
		'ext.CaptchaAction',
		'ext.LinkPager',
		'ext.image.Image',
        'ext.YiiMongoDbSuite.*',
        'application.modules.geo.models.*',
        'application.modules.scores.models.*',
        'application.modules.calendar.models.*',
        'application.modules.cook.models.*',
        'application.modules.contest.models.*',
        'application.modules.whatsNew.models.*',
        'application.modules.whatsNew.components.*',
        'application.modules.whatsNew.widgets.whatsNewWidget.WhatsNewWidget',
        'application.modules.messaging.components.*',
        'application.modules.messaging.models.*',
        'application.modules.friends.models.*',
        'ext.directmongosuite.*',
        'application.modules.notifications.models.base.*',
        'application.modules.notifications.models.*',
        'application.modules.notifications.components.*',
        'application.modules.scores.components.*',
        'application.modules.scores.models.*',
        'application.modules.scores.models.input.*',
        'application.modules.favourites.models.*',
        'application.modules.favourites.widgets.*',
        'application.modules.favourites.components.*',
        'site.common.extensions.imperavi-redactor-widget.ImperaviRedactorWidget',
        'application.widgets.userAvatarWidget.*',
        'application.modules.gallery.components.*',
        'application.modules.gallery.widgets.*',
        'application.modules.myGiraffe.models.*',
        'application.modules.myGiraffe.components.*',
        'application.modules.community.models.*',
        'ext.captchaExtended.*',
        'application.modules.antispam.models.*',
        'application.modules.antispam.components.*',
        'application.modules.signup.widgets.*',
        'application.modules.signup.models.*',

        'zii.behaviors.CTimestampBehavior',
        'site.common.extensions.wr.WithRelatedBehavior',
        'site.frontend.modules.antispam.behaviors.AntispamBehavior',
        'site.common.behaviors.*',
        'site.frontend.extensions.status.EStatusBehavior',
        'site.frontend.extensions.geturl.EGetUrlBehavior',

        'application.modules.onlineManager.widgets.*',
        'application.modules.onlineManager.components.*',
    ),

	'sourceLanguage' => 'en',
	'language' => 'ru',

    /* Техническое обслуживание */
    /*'catchAllRequest' => (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '88.87.70.93', '178.35.209.102', '91.205.122.228')))?null:array(
        '/site/maintenance',
    ),*/
    'behaviors' => array(
        'edms' => array(
            'class'=>'EDMSBehavior',
            'connectionId' => 'mongodb',
        )
    ),
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
        'im',
        'geo',
        'signal',
        'scores',
        'services',
        'cook',
        'calendar',
        'whatsNew',
        'valentinesDay',
        'routes',
        'messaging',
        'notifications' => array(
            'class' => 'site\frontend\modules\notifications\NotificationsModule',
        ),
        'comments' => array(
            'class' => 'site\frontend\modules\comments\CommentsModule',
        ),
        'friends',
        'favourites',
        'scores',
        'blog',
        'gallery',
        'profile',
        'search',
        'community',
        'myGiraffe',
        'family',
        'antispam',
        'signup',
        'mail',
        'developers',
        'seo' => array(
            'class' => '\site\frontend\modules\seo\SeoModule',
        ),
	),
	// application components
	'components'=>array(
        'ads' => array(
            'class' => 'Ads',
        ),
        'gearman' => array(
            'class' => 'site.common.components.Gearman',
        ),
        'postman' => array(
            'class' => 'application.modules.mail.components.MailPostman',
        ),
        'securityManager' => array(
            'validationKey' => '44ffc48eb95b605d20804ce9dff63ca7e1698d80',
        ),
        'contentCompactor' => array(
            'class' => 'ext.contentCompactor.ContentCompactor',
            'options' => array(
                'strip_comments' => false,
                'compress_scripts' => false,
            ),
        ),
        'coreMessages' => array(
            'basePath' => null,
        ),
        'clientScript' => require_once(dirname(__FILE__) . '/clientScript.php'),
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
					'ckEditor' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www-submodule' . DIRECTORY_SEPARATOR . 'ckeditor' . DIRECTORY_SEPARATOR . 'ckeditor.php',
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
            'popup' => true,
            'cache' => false,
            'cacheExpire' => 0,
			'services' => array( // You can change the providers and their classes.
//                'mailru' => array(
//                    'class' => 'CustomMailruService',
//                    'client_id' => '667969',
//                    'client_secret' => '3a0e2674098641394a8e5e0b4328e594',
//                    'title' => 'Mail.ru',
//                ),
                'odnoklassniki' => array(
                    'class' => 'application.components.eauth.OdnoklassnikiAuth',
                    'client_id' => '93721600',
                    'client_secret' => '4E774EFE678A1ECF3D4625F3',
                    'client_public' => 'CBAFBHJGABABABABA',
                    'title' => 'Одноклассники',
                ),
                'vkontakte' => array(
                    'class' => 'application.components.eauth.VkontakteAuth',
                    'client_id' => '2855330',
                    'client_secret' => 'T9pHwkodkssoEjswy2fw',
                    'title' => 'ВКонтакте',
                ),
//                'facebook' => array(
//                    'class' => 'CustomFacebookService',
//                    'client_id' => '412497558776154',
//                    'client_secret' => 'dc98234daa8c7a0d943a92423793590d',
//                    'title' => 'Facebook',
//                ),
                /*'google' => array(
                    'class' => 'CustomGoogleService',
                    'client_id' => '999100941078.apps.googleusercontent.com',
                    'client_secret' => '6fDvpI0FO0lmhdDTMCl-I8gD',
                ),*/
//                'twitter' => array(
//                    'class' => 'CustomTwitterService',
//                    'key' => '9NY9gDqPgU2DMIYrEv2pCA',
//                    'secret' => '2Lk4Q34fINqSrx5BlpKz6qtyCsofI3M9FHRYCElceE',
//                    'title' => 'Twitter',
//                ),
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
            'autoRenewCookie'=>true,
			'loginUrl'=> array('/site/index', 'openLogin' => 1),
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
            'schemaCachingDuration' => 300,
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
        'db_keywords' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=keywords',
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
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'info',
                    'logFile' => 'info.log',
                ),
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
//                array(
//					'class'=>'CEmailLogRoute',
//					'levels'=>'error, warning',
//					'emails'=>'pavel@happy-giraffe.ru',
//				),
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
        'piwik' => array(
            'class' => 'site.common.components.Piwik',
            'token_auth' => '2e20e09969eb34201467c8339dce749d',
            'idSite' => 1,
        ),
        'phpThumb' => array(
            'class' => 'ext.EPhpThumb.EPhpThumb',
            'options' => array(
                'resizeUp' => true,
                'jpegQuality' => 70,
            ),
        ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
        'valentinesAlbum' => '41340',
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
                'jquery.powertip.js',
                'knockout-2.2.1.js',
                'knockout-3.0.0.js',
                'ko_library.js',
                'history.js',
                'ko_favourites.js',
                'upload.js',
                'jquery.ui.widget.js',
                'jquery.iframe-transport.js',
                'jquery.fileupload.js',
                'ko_post.js',
                'baron.js',
                'knockout.mapping-latest.js',
                'comments.js',
                'wysiwyg.js',
                'auth.js',
                'jquery.fitvids.js',
                'jquery.lwtCountdown-1.0.js',
                'FavouriteWidget.js',
                'jquery.history.js',
                'ko_gallery.js',
                'PhotoCollectionViewWidget.js',
                'chosen.jquery.min.js',
                'tooltipsy.min.js',
                'jquery.placeholder.min.js',
                'addtocopy.js',
                'jquery.fancybox-1.3.4.js',
                'base64.js',
                '/javascripts/common.js',
                'fox.js',
                'jquery.Jcrop.min.js',
                'ko_blog.js',
                'ko_community.js',
                'ko_photoWidget.js',
                'ko_layout.js',
                'social.js',
            ),
        ),
	),

        'controllerMap' => array(
            'sitemap' => array(
                'class' => 'ext.sitemapgenerator.SGController',
                'import'=>array(
                    'routes.models.Route'
                ),
                'config' => array(
                    'sitemap.xml' => array(
                        'index' => true,
                    ),
                    'sitemapCommunity1.xml' => array(
                        'aliases' => array(
                            'application.modules.community.controllers.DefaultController',
                        ),
                        'param' => 1,
                    ),
                    'sitemapCommunity2.xml' => array(
                        'aliases' => array(
                            'application.modules.community.controllers.DefaultController',
                        ),
                        'param' => 2,
                    ),
                    'sitemapBlog1.xml' => array(
                        'aliases' => array(
                            'application.modules.blog.controllers.DefaultController',
                        ),
                        'param' => 1,
                    ),
                    'sitemapBlog2.xml' => array(
                        'aliases' => array(
                            'application.modules.blog.controllers.DefaultController'
                        ),
                        'param' => 2,
                    ),
                    'sitemapCook.xml' => array(
                        'aliases' => array(
                            'application.modules.cook.controllers.SpicesController',
                            'application.modules.cook.controllers.ChooseController',
                            'application.modules.cook.controllers.RecipeController',
                        ),
                    ),
                    'sitemapDecor.xml' => array(
                        'aliases' => array(
                            'application.modules.cook.controllers.DecorController',
                        ),
                    ),
                    'sitemapRoutes1.xml' => array(
                        'aliases' => array(
                            'application.modules.routes.controllers.DefaultController',
                        ),
                        'param'=>1
                    ),
//                    'sitemapRoutes2.xml' => array(
//                        'aliases' => array(
//                            'application.modules.routes.controllers.DefaultController',
//                        ),
//                        'param'=>2
//                    ),
//                    'sitemapRoutes3.xml' => array(
//                        'aliases' => array(
//                            'application.modules.routes.controllers.DefaultController',
//                        ),
//                        'param'=>3
//                    ),
//                    'sitemapRoutes4.xml' => array(
//                        'aliases' => array(
//                            'application.modules.routes.controllers.DefaultController',
//                        ),
//                        'param'=>4
//                    ),
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
