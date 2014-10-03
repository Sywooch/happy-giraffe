<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 03/07/14
 * Time: 12:52
 */

namespace site\common\components;
use Imagine\Imagick\Imagine;

class ImagineComponent extends \CApplicationComponent
{
    protected $imagine;

    public function init()
    {
        parent::init();
        $this->imagine = new Imagine();
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->imagine, $method), $args);
    }
} 