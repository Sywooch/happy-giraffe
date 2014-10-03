<?php

namespace site\frontend\modules\editorialDepartment\models;

/**
 * Description of Comment
 *
 * @author Кирилл
 */
class Content extends \EMongoDocument
{

    public $entity;
    public $entityId;
    public $clubId;
    public $title;
    public $markDownPreview;
    public $htmlTextPreview;
    public $markDown;
    public $htmlText;
    public $authorId;
    public $dtimeCreate;
    public $dtimeUpdate;

    public function embeddedDocuments()
    {
        return array(
            'meta' => '\site\frontend\modules\editorialDepartment\models\Meta',
            'social' => '\site\frontend\modules\editorialDepartment\models\Social',
        );
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'editorialDepartmentContent';
    }

}

?>
