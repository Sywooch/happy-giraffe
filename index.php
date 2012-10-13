<?php

defined('YII_DEBUG') or define('YII_DEBUG', TRUE);
require('/opt/yii/framework/yii.php');
$local = require('../config/main-local.php');
$base = require('../config/main.php');
$config = CMap::mergeArray($base, $local);
Yii::createWebApplication($config)->run();
