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
            $data['attributes'] = $this->photo->toJSON();
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
} 