<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 01/07/14
 * Time: 21:02
 */

namespace site\common\components\gaufrette;


use Gaufrette\Filesystem;

abstract class BaseComponent extends \CApplicationComponent
{
    protected $filesystem;
    protected abstract function getAdapter();

    public function init()
    {
        parent::init();


        $this->filesystem = new CustomFilesystem($this->getAdapter());
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->filesystem, $method), $args);
    }
} 