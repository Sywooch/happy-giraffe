<?php
/**
 * Форма загрузки фото
 *
 * Абстрактная модель загрузки фото, от нее необходимо наследовать конкретные модели загрузки
 */

namespace site\frontend\modules\photo\models\upload;
use Aws\CloudFront\Exception\Exception;
use site\frontend\modules\photo\models\Photo;
use site\frontend\modules\photo\models\PhotoCreate;

abstract class UploadForm extends \CFormModel implements \IHToJSON
{
    const PRESET_NAME = 'uploadPreview';

    /**
     * @return PhotoCreate возвращает модель создаваемой фотографии
     */
    abstract protected function populate();

    /**
     * @var PhotoCreate модель создаваемой фотографии
     */
    protected $photo;

    /**
     * @var bool загружено ли фото
     */
    protected $success = false;

    public function attributeLabels()
    {
        return array(
            'photo' => 'Изображение',
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
            try {
                $this->photo = $this->populate();
                if ($this->success = $this->photo->save()) {
                    \Yii::app()->thumbs->getThumb($this->photo, self::PRESET_NAME, true);
                }
            } catch (\Exception $e) {
                $this->addError('photo', 'Неизвестная ошибка');
            }
        }

        return \HJSON::encode(array(
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
        if (! $this->hasErrors() && ! $this->photo->hasErrors()) {
            return null;
        }

        if ($this->hasErrors()) {
            $errors = $this->getErrors();
        } else {
            $errors = $this->photo->getErrors();
        }

        return $errors[key($errors)][0];
    }

    public function toJSON()
    {
        return array(
            'error' => $this->getFirstError(),
            'success' => $this->success,
        );
    }
} 