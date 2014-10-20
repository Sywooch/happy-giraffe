<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class MetaInfo extends SerializedModel
{

    public $title = '';
    public $keywords = '';
    public $description = '';

    public function __construct($data)
    {
        $this - unserialize($data);
    }

    public function attributeNames()
    {
        return array(
            'title',
            'keywords',
            'description',
        );
    }

    public function toJSON()
    {
        
    }

}

?>
