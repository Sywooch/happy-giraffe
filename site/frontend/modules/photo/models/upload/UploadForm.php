<?php
/**
 * Форма загрузки фото
 *
 * Абстрактная модель загрузки фото, от нее необходимо наследовать конкретные модели загрузки
 */

namespace site\frontend\modules\photo\models\upload;
use site\frontend\modules\photo\models\PhotoCreate;

abstract class UploadForm extends \CFormModel
{
    /**
     * @return PhotoCreate возвращает модель создаваемой фотографии
     */
    abstract public function populate();

    /**
     * @var PhotoCreate модель создаваемой фотографии
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

    /**
     * Валидирует текущую форму и модель создания фото, генерирует ответ для клиента
     * @return string JSON для клиента
     */
    public function save()
    {
        $this->photo = $this->populate();

        $success = $this->validate() && $this->photo->save();
        $data = compact('success');
        if ($success) {
            $data['attributes'] = \CMap::mergeArray($this->photo->attributes, array(
                'imageUrl' => $this->photo->getImageUrl(),
                'previewUrl' => $this->getPreviewUrl(),
            ));
        } else {
            $data['error'] = $this->getFirstError();
        }

        return \CJSON::encode($data);
    }

    /**
     * Выбирает первую ошибку из текущей формы и модели создания фотографии
     * @return string текст первой ошибки
     */
    protected function getFirstError()
    {
        $errors = \CMap::mergeArray($this->getErrors(), $this->photo->getErrors());
        return $errors[key($errors)][0];
    }

    /**
     * Создает миниатюру фотографии и возвращает ее URL
     * @return string URL миниатюры фотографии
     * @todo временный метод, убрать после разработки механизма создания миниатюр
     */
    protected function getPreviewUrl()
    {
        /** @var \GdThumb $image */
        $image = \Yii::app()->phpThumb->create($this->photo->getImagePath());

        if (($this->photo->width / $this->photo->height) > (155 / 140)) {
            $image->resize(0, 140);
            $image->cropFromCenter(155, 140);
        } else {
            $image->resize(0, 140);
        }

        $name = $this->photo->getImagePath();
        $name = str_replace($this->photo->fs_name, $this->photo->fs_name . '_preview', $name);
        $image->save($name);
        $url = $this->photo->getImageUrl();
        $url = str_replace($this->photo->fs_name, $this->photo->fs_name . '_preview', $url);
        return $url;
    }
} 