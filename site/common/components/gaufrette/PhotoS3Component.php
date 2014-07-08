<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 21:12
 */

namespace site\common\components\gaufrette;


use Gaufrette\Adapter\Local;

class PhotoS3Component extends S3Component
{
    public $cachePathAlias;

    protected function getAdapter()
    {
        $s3 = parent::getAdapter();
        $local = new CustomLocalAdapter('/var/cache/img_hgru', true);
        return new DeferredCache($s3, $local, 3600);
    }
} 