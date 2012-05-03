<?php

return array(
    'id' => 'happy-giraffe',
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'language'=>'ru',
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
    ),
);