<?php
require_once('/opt/yii/framework/yii.php');
new TestApplication();
YiiBase::setPathOfAlias('site', '/home/giraffe/happy-giraffe.ru/site');
Yii::app()->setAliases(array(
    'Guzzle' => 'site.common.vendor.Guzzle',
    'Symfony' => 'site.common.vendor.Symfony',
));
Yii::app()->setImport(array(
    'site.frontend.tests.PHPUnit.Extensions.Story.*',
));
Yii::app()->setComponent('db', array(
    'connectionString' => 'mysql:host=192.168.56.3;dbname=happy_giraffe2',
    'emulatePrepare' => true,
    'username' => 'giraffe',
    'password' => 'password',
    'charset' => 'utf8',
    'enableProfiling' => true,
    'enableParamLogging' => true,
));
date_default_timezone_set('Europe/Moscow');