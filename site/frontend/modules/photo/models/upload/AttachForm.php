<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 27/06/14
 * Time: 14:23
 */

namespace site\frontend\modules\photo\models\upload;


use site\frontend\modules\photo\models\PhotoAttach;

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
        foreach ($this->ids as $id) {
            $attach = new PhotoAttach();
            $attach->photo_id = $id;
            $attach->collection_id = $this->collectionId;
            $attach->save();
        }
        echo \CJSON::encode(array('success' => true));
    }
} 