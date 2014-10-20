<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class SocialInfo extends SerializedModel
{

    public $title = '';
    public $imageUrl = '';
    public $description = '';

    public function __construct($data)
    {
        $this - unserialize($data);
    }

    public function attributeNames()
    {
        return array(
            'title',
            'imageUrl',
            'description',
        );
    }

    public function toJSON()
    {
        
    }

}

?>
