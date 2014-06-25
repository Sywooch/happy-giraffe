<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 06/06/14
 * Time: 12:13
 */

namespace site\frontend\modules\photo\models\upload;

use site\frontend\modules\photo\models\PhotoCreate;

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

    public function populate()
    {
        $files = \CUploadedFile::getInstancesByName('files');
        foreach ($files as $file) {
            $photo = new PhotoCreate($file->getTempName(), $file->getName());
            $this->photos[] = $photo;
        }
    }
} 