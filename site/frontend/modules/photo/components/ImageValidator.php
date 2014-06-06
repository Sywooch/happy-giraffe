<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 12:20
 */

namespace site\frontend\modules\photo\components;


class FileValidator extends \CValidator
{
    public $types;
    public $mimeTypes;
    public $wrongType;
    public $wrongMimeType;

    protected function validateAttribute($object, $attribute)
    {
        $path = $object->$attribute;
        $this->validateType($object, $attribute, $path) && $this->validateMimeType($object, $attribute, $path);
    }

    protected function validateType($object, $attribute, $path)
    {
        if (is_string($this->types))
            $types = preg_split('/[\s,]+/', strtolower($this->types), -1, PREG_SPLIT_NO_EMPTY);
        else
            $types = $this->types;
        if (! in_array(strtolower(FileHelper::getExtensionName($path)), $types))
        {
            $message = $this->wrongType !== null ? $this->wrongType : \Yii::t('yii','The file "{file}" cannot be uploaded. Only files with these extensions are allowed: {extensions}.');
            $this->addError($object, $attribute, $message, array('{file}' => FileHelper::getName($path), '{extensions}'=>implode(', ', $types)));
        }
    }

    protected function validateMimeType($object, $attribute, $path)
    {

    }
} 