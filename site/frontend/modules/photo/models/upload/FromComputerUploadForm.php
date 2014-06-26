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
    /**
     * @var \CUploadedFile
     */
    public $file;

    public function attributeLabels()
    {
        return \CMap::mergeArray(parent::attributeLabels(), array(
            'file' => 'Файлы изображений',
        ));
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('file', 'file'),
        ));
    }

    public function __construct()
    {
        $this->file = \CUploadedFile::getInstanceByName('image');
    }

    public function populate()
    {
        $photo = new PhotoCreate($this->file->getTempName(), $this->file->getName());
        $this->photos[] = $photo;
    }
} 