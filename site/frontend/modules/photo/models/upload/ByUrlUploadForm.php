<?php
/**
 * Форма загрузки фото по URL
 *
 * Конкретная релизация формы для загрузки фото по URL с внешнего ресурса
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\models\upload;
use Guzzle\Http\Client;

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

    protected function getImageString()
    {
        $client = new Client();
        return $client->get($this->url)->send()->getBody(true);
    }

    protected function getOriginalName()
    {
        return basename($this->url);
    }
} 