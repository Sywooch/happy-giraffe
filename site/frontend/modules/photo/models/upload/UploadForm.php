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
    abstract public function populate();

    /**
     * @var PhotoCreate
     */
    protected $photo;

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
        $this->populate();

        $success = $this->validate() && $this->photo->save();
        $data = compact('success');
        if ($success) {
            $data['attributes'] = $this->photo->attributes;
        }

        return \CJSON::encode($data);
    }
} 