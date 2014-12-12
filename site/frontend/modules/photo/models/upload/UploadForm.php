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
use site\frontend\modules\photo\models\PhotoCollection;

abstract class UploadForm extends \CFormModel implements \IHToJSON
{
    const PRESET_NAME = 'uploadPreview';

    abstract protected function getImageString();
    abstract protected function getOriginalName();

    /**
     * @var \site\frontend\modules\photo\models\Photo модель создаваемой фотографии
     */
    protected $photo;

    /**
     * @var bool загружено ли фото
     */
    protected $success = false;

    protected $collection;
    protected $attach;

    public function __construct($collection = null)
    {
        if ($collection !== null) {
            $this->collection = $collection;
        }
    }

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
                    if ($this->collection !== null) {
                        $attaches = $this->collection->attachPhotos($this->photo->id);
                        $this->attach = $attaches[0];
                        $this->attach->photo = $this->photo;
                    }
                    \Yii::app()->thumbs->getThumb($this->photo, self::PRESET_NAME, true);
                }
            } catch (\Exception $e) {
                $this->addError('photo', 'Ошибка загрузки');
            }
        }

        return $this->success;
    }

    public function toJSON()
    {
        if ($this->collection === null) {
            $json = array(
                'photo' => $this->photo,
            );
        } else {
            $json = array(
                'attach' => $this->attach,
            );
        }
        $json['error'] = $this->getFirstError();
        return $json;
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