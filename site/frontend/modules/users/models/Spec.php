<?php
/**
 * @author Никита
 * @date 14/04/15
 */

namespace site\frontend\modules\users\models;


use site\frontend\modules\posts\models\SerializedModel;

class Spec extends SerializedModel
{
    public $title;
    public $education;

    public function attributeNames()
    {
        return array(
            'title',
            'education',
        );
    }
}