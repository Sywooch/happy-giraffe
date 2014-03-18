<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 18/03/14
 * Time: 13:46
 * To change this template use File | Settings | File Templates.
 */

class CommentRequiredValidator extends RedactorRequiredValidator
{
    protected function validateAttribute($object,$attribute)
    {
        /**
         * @var Comment $object
         */
        if ($object->response !== null) {
            $user = $object->response->author;
            $str = CHtml::link($user->getFullName(), $user->getUrl()) . ',';
            $value = $object->$attribute;
            $object->$attribute = str_replace($str, '', $value);
            parent::validateAttribute($object, $attribute);
            $object->$attribute = $value;
        }
        else
            parent::validateAttribute($object, $attribute);
    }
}