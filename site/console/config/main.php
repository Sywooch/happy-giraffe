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
        'email' => array(
            'class' => 'site.frontend.modules.mail.commands.DefaultCommand',
        ),
    ),
    'import' => array(
        'site.common.components.*',
        'site.common.behaviors.*',
        'site.common.models.*',
        'site.common.helpers.*',
        'site.frontend.components.*',
        'site.frontend.helpers.*',
        'site.frontend.extensions.image.Image',
        'site.frontend.extensions.phpQuery.phpQuery',
        'site.frontend.extensions.directmongosuite.*',
        'site.frontend.modules.antispam.models.*',
        'site.frontend.modules.antispam.components.*',
        'site.frontend.modules.onlineManager.widgets.*',
        'site.frontend.modules.onlineManager.components.*',
        'site.frontend.modules.geo.models.*',
        'site.frontend.modules.geo.components.*',
    ),
    'behaviors' => array(
        'edms' => array(
            'class'=>'EDMSBehavior',
            'connectionId' => 'mongodb',
        )
    ),
    'components' => array(
        'statePersister'=> array(
            'stateFile' => Yii::getPathOfAlias('site.frontend.runtime') . DIRECTORY_SEPARATOR . 'state.bin',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'JabberLogRoute',
                    'file' => ' /etc/sendxmpprc_www',
                    'name' => 'Warner',
                    'room' => 'hg-tech-warnings@conference.jabber.ru',
                    'levels' => 'error',
                    'categories' => 'mail',
                ),
            ),
        ),
        'indexden' => array(
            'class' => 'site.common.components.IndexDen',
            'apiUrl' => 'http://:tebadytarure@nygeme.api.indexden.com',
        ),
        'gearman' => array(
            'class' => 'site.common.components.Gearman',
            'servers' => array(
                array('host' => '127.0.0.1', 'port' => 4730),
            ),
        ),
        'request' => array(
            'hostInfo' => 'http://www.happy-giraffe.ru',
            'baseUrl' => '',
            'scriptUrl' => '',
        ),
        'comet'=>array(
            'class' => 'site.frontend.extensions.Dklab_Realplexor',
            'host' => 'plexor.www.happy-giraffe.ru',
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
        'mongodb_parsing' => array(
            'class' => 'EMongoDB',
            'connectionString' => 'mongodb://5.9.7.81',
            'dbName' => 'parsing',
            'fsyncFlag' => true,
            'safeFlag' => true,
            'useCursor' => false
        ),
        'edms' => array(
            'class'            => 'EDMSConnection',
            'dbName'           => 'happy_giraffe_db',
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
        'urlManager'=>require_once(dirname(__FILE__).'/../../frontend/config/url.php'),
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
        'phpThumb' => array(
            'class' => 'site.frontend.extensions.EPhpThumb.EPhpThumb',
            'options' => array(
                'resizeUp' => true,
            ),
        ),
    ),
    'params'=>array(
        'photos_url'=>'http://img.happy-giraffe.ru',
        'use_proxy_auth'=>true,
    ),
);