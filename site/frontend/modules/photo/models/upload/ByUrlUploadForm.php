<?php
/**
 * Форма загрузки фото по URL
 *
 * Конкретная релизация формы для загрузки фото по URL с внешнего ресурса
 */

namespace site\frontend\modules\photo\models\upload;
use site\frontend\modules\photo\models\PhotoCreate;

class ByUrlUploadForm extends UploadForm
{
    /**
     * @var string URL изображения
     */
    public $url;

    public function attributeLabels()
    {
        return \CMap::mergeArray(parent::attributeLabels(), array(
            'url' => 'Ссылка',
        ));
    }

    public function rules()
    {
        return \CMap::mergeArray(parent::rules(), array(
            array('url', 'url'),
        ));
    }

    protected function populate()
    {
        $image = file_get_contents($this->url);
        $tmpFile = tempnam(sys_get_temp_dir(), 'php');
        file_put_contents($tmpFile, $image);
        return new PhotoCreate($tmpFile, basename($this->url));
    }
} 