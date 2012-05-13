<?php

return array(
	'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
	'name' => 'Seo admin panel',
    'language'=>'ru',
    'preload'=>array('log'),
	'import'=>array(
        'application.models.*',
        'application.components.*',

        'site.common.components.*',
        //'site.common.models.*',
        //'site.common.models.mongo.*',
        'site.frontend.helpers.FileHandler',
        'site.frontend.helpers.CArray',
        'site.frontend.helpers.*',
        'site.common.helpers.*',
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
            ),
        ),
		'urlManager' => array(
			'urlFormat'=>'path',
            'showScriptName'=>false
		),
        'db' => array(
            'schemaCachingDuration' => 3600,
            'enableProfiling' => true,
            'enableParamLogging' => true,
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
	),

    'params' => array(
        'ufileStorageRoot' => 'temp_upload',
        'frontend_url'=>'http://www.happy-giraffe.ru/'
    )
);