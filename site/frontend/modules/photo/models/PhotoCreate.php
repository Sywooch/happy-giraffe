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
            $this->addError($attribute, 'Изображение должно быть изображение в формате JPEG, PNG или GIF');
        }
    }

    protected function getExtension()
    {
        $typeToExtension = array(IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif', IMAGETYPE_PNG => 'png');
        return $typeToExtension[$this->type];
    }

    protected function getFsName()
    {
        $hash = md5(uniqid($this->original_name . microtime(), true));

        $path = '';
        for ($i = 0; $i < self::FS_NAME_LEVELS; $i++) {
            $dirName = substr($hash, $i * self::FS_NAME_SYMBOLS_PER_LEVEL, self::FS_NAME_SYMBOLS_PER_LEVEL);
            $path .= $dirName . DIRECTORY_SEPARATOR;
        }

        $dir = PathManager::getOriginalsPath() . DIRECTORY_SEPARATOR . $path;
        if (! is_dir($dir) && ! mkdir($dir, 0777, true)) {
            throw new \CException('Невозможно создать папку');
        }

        $path .= substr($hash, self::FS_NAME_LEVELS * self::FS_NAME_SYMBOLS_PER_LEVEL) . '.' . $this->getExtension();

        return $path;
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            $this->fs_name = $this->getFsName();
            if (! copy($this->path, $this->getImagePath())) {
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
} 