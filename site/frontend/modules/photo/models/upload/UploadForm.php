<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 05/06/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\models\upload;


class UploadForm extends \CFormModel
{
    protected $images = array();

    public function attributeLabels()
    {
        return array(
            'images' => 'Изображения',
        );
    }

    public function rules()
    {
        return array(

        );
    }

    public function save()
    {
        foreach ($this->images as $image) {

        }
    }
} 