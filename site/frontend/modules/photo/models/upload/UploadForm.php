<?php
/**
 * Форма загрузки фото
 *
 * Абстрактная модель загрузки фото, от нее необходимо наследовать конкретные модели загрузки
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\models\upload;
use site\frontend\modules\photo\models\Photo;

abstract class UploadForm extends \CFormModel implements \IHToJSON
{
    const PRESET_NAME = 'uploadPreview';

    abstract protected function getImageString();
    abstract protected function getOriginalName();

    /**
     * @var \site\frontend\modules\photo\models\Photo модель создаваемой фотографии
     */
    public $photo;

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
                $this->photo = new Photo();
                $this->photo->setImage($this->getImageString());
                $this->photo->original_name = $this->getOriginalName();
                if ($this->success = $this->photo->save()) {
                    \Yii::app()->thumbs->getThumb($this->photo, self::PRESET_NAME, true);
                }
            } catch (\Exception $e) {
                $this->addError('photo', 'Ошибка загрузки');
            }
        }

        return \HJSON::encode(array(
            'photo' => $this->photo,
            'form' => $this,
        ));
    }

    public function toJSON()
    {
        return array(
            'error' => $this->getFirstError(),
            'success' => $this->success,
        );
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
} 