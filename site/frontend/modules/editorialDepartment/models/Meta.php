<?php

namespace site\frontend\modules\editorialDepartment\models;

/**
 * Description of Social
 *
 * @author Кирилл
 */
class Meta extends \EMongoEmbeddedDocument
{

    public $title;
    public $keywords;
    public $description;
    public $canonical;

    public function rules()
    {
        return array(
            array('title, keywords, description, canonical', 'default', 'setOnEmpty' => null),
        );
    }

}

?>
