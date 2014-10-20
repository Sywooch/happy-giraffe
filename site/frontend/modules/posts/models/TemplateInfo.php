<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class TemplateInfo extends SerializedModel
{

    public $layout = '';
    public $data = '';

    public function attributeNames()
    {
        return array(
            'layout',
            'data',
        );
    }

    public function toJSON()
    {
        
    }

}

?>
