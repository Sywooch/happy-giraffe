<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 12:13
 */

namespace site\frontend\modules\photo\models\upload;


class FromComputerUploadForm extends UploadForm
{
    public $files;

    public function attributeLabels()
    {
        return \CMap::mergeArray(parent::attributeLabels(), array(
            'files' => 'Файлы изображений',
        ));
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('files', 'file'),
        ));
    }

    public function __construct()
    {
        $files = \CUploadedFile::getInstancesByName('files');
        foreach ($files as $file) {
            $this->images[] = $file;
        }
    }
} 