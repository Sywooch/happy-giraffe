<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 21:58
 */

namespace site\common\components\gaufrette;


use Gaufrette\Adapter\Cache;

class CustomCache extends Cache
{
    public function exists($key)
    {
        if ($this->needsReload($key)) {
            return $this->source->exists($key);
        } else {
            return $this->cache->exists($key);
        }
    }

    public function getUrl($key)
    {


        if (method_exists($this->cache, 'getUrl')) {
            return $this->cache->getUrl($key);
        }
        if (method_exists($this->source, 'getUrl')) {
            return $this->source->getUrl($key);
        }
        return null;
    }
} 