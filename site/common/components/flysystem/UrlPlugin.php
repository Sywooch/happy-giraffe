<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 13:07
 */

namespace site\common\components\flysystem;
use League\Flysystem\FilesystemInterface;
use League\Flysystem\PluginInterface;

class UrlPlugin implements PluginInterface
{
    /**
     * @var FileSystemInterface
     */
    protected $filesystem;

    public function setFilesystem(FilesystemInterface $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function getMethod()
    {
        return 'getUrl';
    }

    public function handle($path = null)
    {
        $adapter = $this->filesystem->getAdapter();
        if ($adapter instanceof S3Adapter) {
            return 'https://' . $adapter->bucket . '.s3.amazonaws.com/' . $path;
        }
        return null;
    }
}