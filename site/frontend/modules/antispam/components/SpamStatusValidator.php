<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 16/01/14
 * Time: 17:22
 * To change this template use File | Settings | File Templates.
 */

class SpamStatusValidator extends CValidator
{
    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        if (in_array(AntispamStatusManager::getUserStatus($value), array(AntispamStatusManager::STATUS_BLACK, AntispamStatusManager::STATUS_BLOCKED)))
            $object->addError('author_id', 'Вы заблокированы.');
    }
}