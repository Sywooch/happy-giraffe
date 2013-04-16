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
        'site.common.behaviors.*',
        'site.common.models.*',
        'site.common.helpers.*',
        'site.frontend.extensions.image.Image',
        'site.frontend.extensions.phpQuery.phpQuery',
        'site.common.components.AMQP.*',
        'site.common.components.AMQP.fake.*',
    ),
    'components' => array(
        'amqp' => array(
            'class' => 'site.common.components.AMQClient',
            'host'  => 'localhost'
        ),
        'gearman' => array(
            'class' => 'site.common.components.Gearman',
            'servers'=>array(),
        ),
        'request' => array(
            'hostInfo' => 'http://www.happy-giraffe.ru',
            'baseUrl' => '',
            'scriptUrl' => '',
        ),
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
        'mongodb_production' => array(
            'class' => 'EMongoDB',
            'connectionString' => 'mongodb://localhost',
            'dbName' => 'happy_giraffe_production',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false
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
    ),
    'params'=>array(
        'photos_url'=>'http://img.happy-giraffe.ru',
        'use_proxy_auth'=>true,
    ),
);