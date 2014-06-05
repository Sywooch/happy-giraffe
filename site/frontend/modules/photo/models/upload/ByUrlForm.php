<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 30/05/14
 * Time: 10:52
 */

namespace site\frontend\modules\photo\models\upload;


class UrlForm extends \CFormModel
{
    public $url;

    public function attributeLabels()
    {
        return array(
            'url' => 'Ссылка на изображение',
        );
    }
} 