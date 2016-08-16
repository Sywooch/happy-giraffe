<?php
/**
 * @author Никита
 * @date 15/08/16
 */

namespace site\frontend\modules\users\models;


use site\frontend\modules\posts\models\SerializedModel;

class SpecialistInfo extends SerializedModel
{
    public $title;

    public function attributeNames()
    {
        return array(
            'title',
        );
    }

    public function serialize()
    {
        $attributes = array_filter($this->attributes);
        return (empty($attributes)) ? '' : parent::serialize();
    }
}