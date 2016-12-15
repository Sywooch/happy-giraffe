<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once __DIR__ . '/../../../../../yii-1.1.17/yii.php';

if (file_exists(__DIR__ . '/../../common/config/main.php') && is_file(__DIR__ . '/../../common/config/main.php')) {
    $common = require(__DIR__ . '/../../common/config/main.php');
    $commonLocal = require(__DIR__ . '/../../common/config/main-local.php');
} else {
    $common = [];
    $commonLocal = [];
}

$base = require(__DIR__ . '/../../frontend/config/main.php');
$baseLocal = require(__DIR__ . '/../../frontend/config/main-local.php');

$config = CMap::mergeArray($common, $commonLocal, $base, $baseLocal);

new TestApplication($config);

YiiBase::setPathOfAlias('site', '/home/giraffe/happy-giraffe.ru/site');

Yii::app()->setAliases([
    'Guzzle' => 'site.common.vendor.Guzzle',
    'Symfony' => 'site.common.vendor.Symfony',
]);
Yii::app()->setImport([
    'site.frontend.tests.PHPUnit.Extensions.Story.*',
]);

Yii::app()->setComponent('db', [
    'connectionString' => 'mysql:host=192.168.56.3;dbname=happy_giraffe2',
    'emulatePrepare' => true,
    'username' => 'giraffe',
    'password' => 'password',
    'charset' => 'utf8',
    'enableProfiling' => true,
    'enableParamLogging' => true,
]);
date_default_timezone_set('Europe/Moscow');