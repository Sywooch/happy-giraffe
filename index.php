<?php

defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// change the following paths if necessary
$yii=dirname(__FILE__).'/../../../../../home/yii/framework/YiiBase.php';
$local = dirname(__FILE__).'/../config/main-local.php';
$base = dirname(__FILE__).'/../config/main.php';

require_once($yii);

class Yii extends YiiBase
{
    /**
     * @static
     * @return CWebApplication
     */
    public static function app()
    {
        return parent::app();
    }
}

$base=require($base);
$local=require($local);
$config = CMap::mergeArray($base, $local);

Yii::createWebApplication($config)->run();
