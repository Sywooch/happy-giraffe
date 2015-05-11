<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class ManageInfo extends SerializedModel
{

    public $link = false;
    public $params = false;

    public function attributeNames()
    {
        return array(
            'link',
            'params',
        );
    }

}

?>
