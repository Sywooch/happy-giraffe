<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 20:09
 */

namespace site\common\components\flysystem;


use League\Flysystem\Adapter\Local;
use League\Flysystem\Cache\Adapter;

class PhotoS3Component extends S3Component
{
    public $cachePathAlias;

    protected function getAdapter()
    {
        $s3 = parent::getAdapter();
        $local = new Local(\Yii::getPathOfAlias($this->cachePathAlias));
        return new CacheAdapter($s3, $local, 300);
    }
} 