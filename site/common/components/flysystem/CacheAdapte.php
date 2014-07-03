<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 03/07/14
 * Time: 18:03
 */

namespace site\common\components\flysystem;


use League\Flysystem\Adapter\AbstractAdapter;

class CacheAdapter extends AbstractAdapter
{
    /**
     * @var AbstractAdapter
     */
    protected $cache;

    /**
     * @var AbstractAdapter
     */
    protected $source;

    /**
     * @var integer
     */
    protected $ttl;

    public function __construct(AbstractAdapter $source, AbstractAdapter $cache, $ttl = 0)
    {
        $this->cache = $cache;
        $this->source = $source;
    }

    public function write($path, $contents, $config = null)
    {
        $this->source->write($path, $contents, $config);

        return $this->cache->write($path, $contents, $config);
    }

    public function getTimestamp($path)
    {
        return $this->getMetadata($path);
    }

    public function read($path)
    {
        if ($this->needsReload($path)) {
            $contents = $this->source->read($path);
            $this->cache->write($path, $contents);
        } else {
            $contents = $this->cache->read($path);
        }

        return compact($contents, $path);
    }

    public function has($path)
    {
        if ($this->needsReload($path)) {
            return $this->source->has($path);
        }
        return $this->cache->has($path);
    }

    public function needsReload($key)
    {
        $needsReload = true;

        if ($this->cache->has($key)) {
            try {
                $dateCache = $this->cache->getTimestamp($key);
                $needsReload = false;

                if (time() - $this->ttl >= $dateCache) {
                    $dateSource = $this->source->getTimestamp($key);
                    $needsReload = $dateCache < $dateSource;
                }
            } catch (\RuntimeException $e) { }
        }

        return $needsReload;
    }
} 