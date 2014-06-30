<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/06/14
 * Time: 10:18
 */

namespace site\common\components\flysystem;
use League\Flysystem\Adapter\Local;

class LocalComponent extends BaseComponent
{
    /**
     * @var string алиас пути
     */
    public $pathAlias;

    /**
     * @return Local
     */
    protected function getAdapter()
    {
        return new Local(\Yii::getPathOfAlias($this->pathAlias));
    }
} 