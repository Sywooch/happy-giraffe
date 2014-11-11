<?php

namespace site\frontend\modules\posts\models;

/**
 * Description of ManageInfo
 *
 * @author Кирилл
 */
class SocialInfo extends SerializedModel implements \IPreview
{

    public $title = null;
    public $imageUrl = null;
    public $description = null;

    public function attributeNames()
    {
        return array(
            'title',
            'imageUrl',
            'description',
        );
    }

    public function getPreviewPhoto()
    {
        return $this->imageUrl;
    }

    public function getPreviewText()
    {
        return $this->description;
    }

}

?>
