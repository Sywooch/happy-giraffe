<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class MetaInfo extends SerializedModel
{

    public $title = null;
    public $keywords = null;
    public $description = null;

    public function attributeNames()
    {
        return array(
            'title',
            'keywords',
            'description',
        );
    }

}

?>
