<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 12:20
 */

namespace site\frontend\modules\photo\components;


class ImageValidator extends \CValidator
{
    public $types;

    protected function validateAttribute($object, $attribute)
    {
        $path = $object->$attribute;
        $imageSize = getimagesize($path);
    }
} 