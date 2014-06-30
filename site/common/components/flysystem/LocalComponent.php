<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 10:18
 */

namespace site\common\components\flysystem;
use League\Flysystem\Filesystem;
use League\Flysystem\Adapter\Local as Adapter;

class LocalComponent extends BaseComponent
{
    public $pathAlias;

    protected function getAdapter()
    {
        return new Filesystem(new Adapter(\Yii::getPathOfAlias($this->pathAlias)));
    }
} 