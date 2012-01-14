<?php

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../../../../home/yii/framework/yii.php';
$local = dirname(__FILE__).'/../config/main-local.php';
$base = dirname(__FILE__).'/../config/main.php';

require_once($yii);

$base=require($base);
$local=require($local);
$config = CMap::mergeArray($base, $local);

Yii::createWebApplication($config)->run();
