<?php

YiiBase::setPathOfAlias('site', 'Z:/happy-giraffe/site/');

return array(
    'components' => array(
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=happy_giraffe',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'schemaCachingDuration' => 60,
            'enableProfiling' => true,
            'enableParamLogging' => true,
            'tablePrefix' => '',
        ),
        'cache' => array(
            'class' => 'CMemCache',
            'servers' => array(
                array(
                    'host' => 'localhost',
                    'port' => 11211,
                    'weight' => 100,
                ),
            ),
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
//                array(
//                    'class' => 'CWebLogRoute',
//                    'categories' => 'system.db.CDbCommand',
//                    'showInFireBug' => false,
//                ),
            ),
        ),
    ),
    'modules' => array(
        'gii' => array(
            'password' => '123',
        )
    ),
);