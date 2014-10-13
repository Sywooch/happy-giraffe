<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 02/07/14
 * Time: 16:17
 */

namespace site\common\components\gaufrette;


use Gaufrette\Adapter\Local;

class CustomLocalAdapter extends Local
{
    public function getUrl($key)
    {
        return \Yii::app()->params['photos_url'] . '/v2/' . $key;
    }
} 