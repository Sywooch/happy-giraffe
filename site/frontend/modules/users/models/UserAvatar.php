<?php

namespace site\frontend\modules\users\models;
use site\frontend\modules\posts\models\SerializedModel;

/**
 * @author Никита
 * @date 19/12/14
 */

class UserAvatar extends SerializedModel
{
    public $small;
    public $medium;
    public $big;

    public function attributeNames()
    {
        return array(
            'small',
            'medium',
            'big',
        );
    }
} 