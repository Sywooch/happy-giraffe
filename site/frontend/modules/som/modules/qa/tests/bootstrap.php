<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
require_once('/opt/yii/framework/yii.php');
$yiit='/opt/yii/framework/yiit.php';
if (is_file('/home/giraffe/happy-giraffe.ru/site/common/config/main.php')) {
    $common = require('/home/giraffe/happy-giraffe.ru/site/common/config/main.php');
    $commonLocal = require('/home/giraffe/happy-giraffe.ru/site/common/config/main-local.php');
} else {
    $common = array();
    $commonLocal = array();
}
$base = require('/home/giraffe/happy-giraffe.ru/site/frontend/config/main.php');
$baseLocal = require('/home/giraffe/happy-giraffe.ru/site/frontend/config/main-local.php');
$config = CMap::mergeArray($common, $commonLocal, $base, $baseLocal, array(
    'components' => array(
        'fixture' => array(
            'class' => 'system.test.CDbFixtureManager',
            'basePath' => Yii::getPathOfAlias('site.frontend.modules.som.modules.qa.tests.fixtures'),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=192.168.56.3;dbname=happy_giraffe3',
        ),
    ),
));

require_once($yiit);
Yii::createWebApplication($config);