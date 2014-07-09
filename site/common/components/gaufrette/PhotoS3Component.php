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
    public $cachePath;

    protected function getAdapter()
    {
        $s3 = parent::getAdapter();

        $path = \Yii::getPathOfAlias($this->cachePath);
        if ($path === false) {
            $path = $this->cachePath;
        }

        $local = new CustomLocalAdapter($path, true);
        return new DeferredCache($s3, $local, 3600);
    }
} 