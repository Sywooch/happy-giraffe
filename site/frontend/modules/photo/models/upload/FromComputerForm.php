<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 05/06/14
 * Time: 16:05
 */

namespace site\frontend\modules\photo\models\upload;


class FromComputerForm extends \CFormModel
{
    public $images;

    public function attributeLabels()
    {
        return array(
            'images' => 'Изображения',
        );
    }

    public function rules()
    {
        return array(
            array('images', 'file')
        );
    }
} 