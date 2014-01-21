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
        if (in_array(AntispamStatusManager::getUserStatus($object->author->id), array(AntispamStatusManager::STATUS_BLACK, AntispamStatusManager::STATUS_BLOCKED)))
            $object->addError('author_id', 'Вы заблокированы не можете добавлять записи на сайт.');
    }
}