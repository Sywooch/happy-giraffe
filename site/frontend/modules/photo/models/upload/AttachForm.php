<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 27/06/14
 * Time: 14:23
 */

namespace site\frontend\modules\photo\models\upload;


use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\PhotoCollection;

class AttachForm extends \CFormModel
{
    public $ids;
    public $collectionId;

    public function rules()
    {
        return array(
            array('ids, collectionId', 'safe'),
        );
    }

    public function save()
    {
        $collection = PhotoCollection::model()->findByPk($this->collectionId);
        $collection->attach($this->ids);
        echo \CJSON::encode(array('success' => true));
    }
} 