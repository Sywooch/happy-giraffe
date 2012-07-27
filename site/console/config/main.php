<?php
date_default_timezone_set('Europe/Moscow');
return array(
    'id' => 'happy-giraffe',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'preload'=>array('log'),
    'commandMap' => array(
        'migrate' => array(
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'site.common.migrations',
        ),
    ),
    'import' => array(
        'site.common.components.*',
        'site.common.models.*',
        'site.console.models.*',
    ),
    'components' => array(
        'comet'=>array(
            'class' => 'site.frontend.extensions.Dklab_Realplexor',
            'host' => 'www.plexor.happy-giraffe.ru',
            'port' => 10010,
            'namespace' => 'crm_',
        ),
        'cache' => array(
            'class' => 'CDummyCache',
//            'class' => 'CMemCache',
        ),
        'mongodb' => array(
            'class'            => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName'           => 'happy_giraffe_db',
            'fsyncFlag'        => true,
            'safeFlag'         => true,
            'useCursor'        => false
        ),
        'db'=>require_once(dirname(__FILE__).'/db.php'),
        'db_seo' => array(
            'class'=>'CDbConnection',
            'connectionString' => 'mysql:host=localhost;dbname=happy_giraffe_seo',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableProfiling' => false,
            'enableParamLogging' => true,
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
        'urlManager'=> include(Yii::getPathOfAlias('site.frontend.config') . DIRECTORY_SEPARATOR . 'url.php'),
    ),
);