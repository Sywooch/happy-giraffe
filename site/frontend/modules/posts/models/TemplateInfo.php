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
    public $data = array();

    public function attributeNames()
    {
        return array(
            'layout',
            'data',
        );
    }

    public function getAttr($name, $defaultValue = null)
    {
        return isset($this->data[$name]) ? $this->data[$name] : $defaultValue;
    }

}

?>
