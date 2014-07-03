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

        $this->success = $this->validate() && $this->photo->save();
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
        $errors = \CMap::mergeArray($this->getErrors(), $this->photo->getErrors());
        if (count($errors) > 0) {
            return $errors[key($errors)][0];
        }
        return '';
    }

    public function toJSON()
    {
        return array(
            'firstError' => $this->getFirstError(),
            'success' => (bool) $this->success,
        );
    }
} 