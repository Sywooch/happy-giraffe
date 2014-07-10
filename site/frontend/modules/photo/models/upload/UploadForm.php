<?php
/**
 * Форма загрузки фото
 *
 * Абстрактная модель загрузки фото, от нее необходимо наследовать конкретные модели загрузки
 */

namespace site\frontend\modules\photo\models\upload;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoCreate;

abstract class UploadForm extends \CFormModel implements \IHToJSON
{
    const PRESET_NAME = 'uploadPreview';

    /**
     * @return PhotoCreate возвращает модель создаваемой фотографии
     */
    abstract public function populate();

    /**
     * @var PhotoCreate модель создаваемой фотографии
     */
    protected $photo;

    /**
     * @var bool загружено ли фото
     */
    protected $success;

    protected $error;

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
        if ($this->validate()) {
            $this->photo = $this->populate();
            if ($this->photo->save()) {
                \Yii::app()->thumbs->getThumb($this->photo, self::PRESET_NAME, true);
            } else {
                $errors = $this->photo->getErrors();
                $this->error = $errors[key($errors)][0];
            }
        } else {
            $errors = $this->getErrors();
            $this->error = $errors[key($errors)][0];
        }

        echo \HJSON::encode(array(
            'photo' => $this->photo,
            'form' => $this,
        ));
    }

    /**
     * Выбирает первую ошибку из текущей формы и модели создания фотографии
     * @return string текст первой ошибки
     */
    protected function getFirstError()
    {
        $errors = $this->photo === null ? $this->getErrors() : $this->photo->getErrors();
        if (count($errors) > 0) {
            return $errors[key($errors)][0];
        }
        return '';
    }

    public function toJSON()
    {
        return array(
            'error' => $this->error,
            'success' => $this->error === null,
        );
    }
} 