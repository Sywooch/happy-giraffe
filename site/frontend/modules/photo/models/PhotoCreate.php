<?php
/**
 * Модель для создания моделей фотографий
 *
 * В эту модель вынесена логика валидации и создания новой модели фотографии
 */

namespace site\frontend\modules\photo\models;


use site\frontend\modules\photo\components\FileHelper;
use site\frontend\modules\photo\components\PathManager;

class PhotoCreate extends Photo
{
    const FS_NAME_LEVELS = 2;
    const FS_NAME_SYMBOLS_PER_LEVEL = 2;

    public $path;
    public $type;

    protected $imageSize;

    public function __construct($path, $originalName)
    {
        parent::__construct();

        $this->original_name = $originalName;
        $this->path = $path;

        try {
            $this->imageSize = getimagesize($this->path);
            $this->width = $this->imageSize[0];
            $this->height = $this->imageSize[1];
            $this->type = $this->imageSize[2];
        } catch (\Exception $e) {
            $this->addError($this->path, 'Некорректный файл изображения');
        }
    }

    public function rules()
    {
        return array(
            array('type', 'validType')
        );
    }

    public function validType($attribute)
    {
        if (! in_array($this->$attribute, array(IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG))) {
            $this->addError($attribute, 'Загружаются только файлы jpg, png, gif');
        }
    }

    protected function getExtension()
    {
        $typeToExtension = array(IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif', IMAGETYPE_PNG => 'png');
        return $typeToExtension[$this->type];
    }

    protected function saveFile()
    {
        $this->fs_name = $this->createFsName($this->getExtension());
        return \Yii::app()->fs->write($this->getOriginalFsPath(), file_get_contents($this->path), true);
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if (! $this->saveFile()) {
                throw new \CException('Невозможно скопировать файл');
            }
            return true;
        }
        return false;
    }

    protected function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->author_id === null && ! \Yii::app()->user->isGuest) {
                $this->author_id = \Yii::app()->user->id;
            }
            return true;
        }
        return false;
    }

    protected function afterSave()
    {
        \Yii::app()->gearman->client()->doBackground('createThumbs', $this->id);
    }
} 