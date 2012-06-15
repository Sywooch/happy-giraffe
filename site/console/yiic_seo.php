<?php

date_default_timezone_set('Europe/Moscow');

// change the following paths if necessary
require_once('Z:\home\yii\framework\yii.php');
$yiic = 'Z:\home\yii\framework\yiic.php';

$local = require(dirname(__FILE__).'\config\main-local-seo.php');
$base = require(dirname(__FILE__).'\config\main.php');
$config = CMap::mergeArray($base, $local);
require_once($yiic);