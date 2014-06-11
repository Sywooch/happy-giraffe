<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 05/06/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\models\upload;

use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoCreate;


abstract class UploadForm extends \CFormModel
{
    /**
     * @var PhotoCreate[]
     */
    protected $photos = array();

    public function attributeLabels()
    {
        return array(
            'photos' => 'Изображения',
        );
    }

    public function rules()
    {
        return array(

        );
    }

    public function save()
    {
        $data = array();
        foreach ($this->photos as $photo) {
            $photo->create();
            $data[] = array(
                'attributes' => \CMap::mergeArray($photo->attributes, array(
                    'originalPath' => $photo->getOriginalUrl(),
                )),
                'errors' => $photo->errors,
            );
        }

        return \CJSON::encode($data);
    }
} 