<?php

namespace site\frontend\modules\editorialDepartment\models;

/**
 * Description of Social
 *
 * @author Кирилл
 */
class Social extends \EMongoEmbeddedDocument
{

    public $title;
    public $text;
    public $image;

    public function rules()
    {
        return array(
            array('title, text, image', 'default', 'setOnEmpty' => null),
        );
    }

}

?>
