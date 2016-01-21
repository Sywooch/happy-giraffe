<?php
/*require_once('/opt/yii/framework/yiit.php');
$config = dirname(__FILE__) . '/../config/test.php';
new TestApplication();

YiiBase::setPathOfAlias('site', '/var/www/giraffe.codetek.ru/site');
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
date_default_timezone_set('Europe/Moscow');*/

$yiit='/opt/yii/framework/yiit.php';
$config=dirname(__FILE__).'/../config/test.php';
require_once($yiit);
//require_once(dirname(__FILE__).'/WebTestCase.php');
YiiBase::setPathOfAlias('site', '/var/www/giraffe.codetek.ru/site');
YiiBase::setPathOfAlias('gallery', '/var/www/giraffe.codetek.ru/site/frontend/modules/gallery');
Yii::createWebApplication($config);