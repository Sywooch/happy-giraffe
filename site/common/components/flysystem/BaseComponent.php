<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 11:28
 */

namespace site\common\components\flysystem;
use League\Flysystem\AdapterInterface;
use League\Flysystem\Filesystem;

abstract class BaseComponent extends \CApplicationComponent
{
    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @return \League\Flysystem\Adapter\AbstractAdapter
     */
    protected abstract function getAdapter();

    public function init()
    {
        parent::init();


        $this->filesystem = new Filesystem($this->getAdapter(), $this->getCache(), array(
            'visibility' => AdapterInterface::VISIBILITY_PUBLIC,
        ));
        $this->filesystem->addPlugin(new UrlPlugin());
    }

    protected function getCache()
    {
        return null;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->filesystem, $method), $args);
    }
} 