<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class ManageInfo extends SerializedModel
{

    public $link = array();

    public function attributeNames()
    {
        return array(
            'link',
        );
    }

    public function toJSON()
    {
        
    }

}

?>
