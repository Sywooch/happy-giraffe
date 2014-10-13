<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 22:05
 */

namespace site\common\components\gaufrette;


use Gaufrette\Filesystem;

class CustomFilesystem extends Filesystem
{
    public function getUrl($key)
    {
        if (method_exists($this->getAdapter(), 'getUrl')) {
            return $this->getAdapter()->getUrl($key);
        }
        return null;
    }
} 