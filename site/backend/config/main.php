<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Админка',
    'language'=>'ru',
    'preload'=>array('log'),
	'import'=>array(
        'site.common.components.*',
        'site.common.models.*',
        'site.common.models.mongo.*',
        'application.models.*',
        'application.components.*',
        'site.frontend.components.Video',
        'site.frontend.helpers.FileHandler',
        'site.frontend.helpers.CArray',
        'site.frontend.components.*',
        'site.frontend.extensions.*',
        'site.frontend.extensions.shoppingCart.*',
        'site.frontend.extensions.LinkPager',
        'site.frontend.extensions.ufile.*',
    	'site.frontend.extensions.image.Image',
        'site.frontend.extensions.YiiMongoDbSuite.*',
        'site.frontend.modules.attribute.models.*',
        'site.frontend.modules.names.models.*',
        'site.frontend.helpers.*',
        'site.common.helpers.*',
        'site.frontend.modules.services.modules.horoscope.models.*',
        'site.frontend.modules.contest.models.*',
        'site.common.models.interest.*',
        'site.frontend.modules.cook.models.*',
        'site.frontend.modules.geo.models.*',
        'site.frontend.modules.scores.models.*',
        'site.frontend.modules.services.modules.recipeBook.models.*',
        'site.frontend.modules.services.modules.test.models.*',
        'site.frontend.modules.services.modules.lines.models.*',
        'site.frontend.modules.route.models.*',
        'site.frontend.modules.valentinesDay.models.*',
    ),
    'modules'=>array(
        'seo',
        'mail',
        'club',
        'cook',
        'geo',
    ),
	'components' => array(
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
		'urlManager' => array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
            'urlSuffix' => '/',
            'rules' => array(
                'http://www.happy-giraffe.ru/user/<user_id:\d+>' => 'user/profile',
                'http://www.happy-giraffe.ru/community/<community_id:\d+>/forum/<content_type_slug:\w+>/<content_id:\d+>' => 'community/view',
            ),
		),
        'db' => array(
            'schemaCachingDuration' => 3600,
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix'=> '',
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            'connectionID'=>'db',
            'itemTable'=>'auth__items',
            'itemChildTable'=>'auth__items_childs',
            'assignmentTable'=>'auth__assignments',
            'defaultRoles' => array('guest'),
        ),
        'mongodb' => array(
            'class'            => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName'           => 'happy_giraffe_db',
            'fsyncFlag'        => true,
            'safeFlag'         => true,
            'useCursor'        => false
        ),
        'cache'=>array(
            //	'class' => 'CMemCache',
            'class' => 'CDummyCache',
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
        'mc' => array(
            'class' => 'site.common.extensions.mailchimp.MailChimp',
            'apiKey' => '761494406f3754b8128246285e00b703-us5',
            'list' => '5772c2a539'
        )
	),

    'params' => array(
        'ufileStorageRoot' => 'temp_upload',
        'frontend_url'=>'http://www.happy-giraffe.ru/',
        'photos_url'=>'http://img.happy-giraffe.ru',
    ),
);