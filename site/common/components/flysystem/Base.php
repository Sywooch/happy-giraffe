<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 11:28
 */

namespace site\common\components\flysystem;
use League\Flysystem\Filesystem;

abstract class Base extends \CApplicationComponent
{
    protected $filesystem;

    protected abstract function getAdapter();

    public function init()
    {
        parent::init();
        $this->filesystem = $this->getAdapter();
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->filesystem, $method), $args);
    }
} 