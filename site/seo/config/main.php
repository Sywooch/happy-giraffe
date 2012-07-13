<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Seo admin panel',
    'language' => 'ru',
    'preload' => array('log'),
    'import' => array(
        'site.common.models.*',
        'site.common.components.*',
        'site.common.behaviors.*',
        'site.common.behaviors.*',
        'site.common.extensions.wr.WithRelatedBehavior',

        'site.frontend.helpers.FileHandler',
        'site.frontend.components.*',
        'site.frontend.helpers.CArray',
        'site.frontend.helpers.*',
        'site.frontend.extensions.YiiMongoDbSuite.*',
        'site.frontend.extensions.ESaveRelatedBehavior',

        'application.models.*',
        'application.models.mongo.*',
        'application.models.forms.*',
        'application.components.*',
        'application.modules.competitors.models.*',
        'application.modules.writing.models.*',
        'application.modules.promotion.models.*',
    ),
    'modules' => array(
        'competitors',
        'writing',
        'promotion',
        'admin',
        'indexing',
        'statistic',
    ),
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            'allowAutoLogin' => true,
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
            ),
        ),
        'urlManager' => require_once(dirname(__FILE__) . '/url.php'),
        'db' => array(
            'schemaCachingDuration' => 3600,
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix' => '',
        ),
        'db_seo' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=happy_giraffe_seo',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 60,
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db_seo',
            'itemTable' => 'auth__items',
            'itemChildTable' => 'auth__items_childs',
            'assignmentTable' => 'auth__assignments',
            'defaultRoles' => array('guest'),
        ),
        'mongodb' => array(
            'class' => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName' => 'happy_giraffe_db',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false
        ),
        'cache' => array(
            'class' => 'CFileCache',
//            'class' => 'CDummyCache',
        ),
//        'log' => array(
//            'class' => 'CLogRouter',
//            'routes' => array(
//                array(
//                    'class' => 'CFileLogRoute',
//                    'levels' => 'trace, info, profile, warning, error',
//                ),
//            ),
//        ),
        'search' => array(
            'class' => 'site.frontend.extensions.DGSphinxSearch.DGSphinxSearch',
            'server' => '127.0.0.1',
            'port' => 9312,
            'maxQueryTime' => 3000,
            'enableProfiling' => 0,
            'enableResultTrace' => 0,
            'fieldWeights' => array(
                'name' => 10000,
                'keywords' => 100,
            ),
        ),
        'comet' => array(
            'class' => 'site.frontend.extensions.Dklab_Realplexor',
            'host' => 'plexor.www.happy-giraffe.ru',
            'port' => 10010,
            'namespace' => 'crm_',
        )
    ),

    'params' => array(
        'ufileStorageRoot' => 'temp_upload',
        'frontend_url' => 'http://www.happy-giraffe.ru/',
        'photos_url' => 'http://img.happy-giraffe.ru/',
    )
);