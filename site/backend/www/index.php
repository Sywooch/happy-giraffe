<?php

defined('YII_DEBUG') or define('YII_DEBUG', TRUE);
require('/home/choo/Mira/happy-giraffe/yii/framework/yii.php');
$local = require('/home/choo/Mira/happy-giraffe/site/backend/config/main-local.php');
$base = require('/home/choo/Mira/happy-giraffe/site/backend/config/main.php');
$config = CMap::mergeArray($base, $local);
Yii::createWebApplication($config)->run();