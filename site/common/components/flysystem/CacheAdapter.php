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

    public function update($path, $contents, $config = null)
    {
        $this->source->update($path, $contents, $config);

        return $this->cache->update($path, $contents, $config);
    }

    public function rename($path, $newpath)
    {
        $this->source->rename($path, $newpath);

        return $this->cache->rename($path, $newpath);
    }

    public function delete($path)
    {
        return $this->source->delete($path) && $this->cache->delete($path);
    }

    public function deleteDir($dirname)
    {
        return $this->source->deleteDir($dirname) && $this->cache->deleteDir($dirname);
    }

    public function getMetadata($path)
    {
        if ($this->needsReload($path)) {
            return $this->source->getMetadata($path);
        } else {
            return $this->cache->getMetadata($path);
        }
    }

    public function getTimestamp($path)
    {
        return $this->getMetadata($path);
    }

    public function getSize($path)
    {
        return $this->getMetadata($path);
    }

    public function getMimetype($path)
    {
        if ($this->needsReload($path)) {
            return $this->source->getMimetype($path);
        } else {
            return $this->cache->getMimetype($path);
        }
    }

    public function read($path)
    {
        if ($this->needsReload($path)) {
            return $this->source->read($path);
        } else {
            return $this->cache->read($path);
        }
    }

    public function has($path)
    {
        if ($this->needsReload($path)) {
            return $this->source->has($path);
        }
        return $this->cache->has($path);
    }

    public function listContents($directory = '', $recursive = false)
    {
        return $this->source->listContents($directory, $recursive);
    }

    public function createDir($dirname, $options = null)
    {
        return $this->source->createDir($dirname, $options) && $this->cache->createDir($dirname, $options);
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