<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 09/06/14
 * Time: 18:57
 */

namespace site\frontend\modules\photo\models;


use site\frontend\modules\photo\components\PathManager;

class PhotoCreate extends Photo
{
    const FS_NAME_LEVELS = 2;
    const FS_NAME_SYMBOLS_PER_LEVEL = 2;

    const MAX_ORIGINAL_WIDTH = 2880;
    const MAX_ORIGINAL_HEIGHT = 1800;

    public $path;

    public function create()
    {
        try {
            $imageSize = getimagesize($this->path);
            $this->width = $imageSize[0];
            $this->height = $imageSize[1];
            $type = $imageSize[2];
            if (! in_array($type, array(IMAGETYPE_JPEG, IMAGETYPE_GIF, IMAGETYPE_PNG))) {
                $this->addError('path', 'Изображение должно быть изображение в формате JPEG, PNG или GIF');
            } else {
                $typeToExtension = array(IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif', IMAGETYPE_PNG => 'png');
                $this->fs_name = $this->generateFsName() . '.' . $typeToExtension[$type];
                $this->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
            $this->addError('path', 'Некорректный файл изображения');
        }
    }

    protected function generateFsName()
    {
        $hash = md5(uniqid($this->original_name . microtime(), true));

        $path = '';
        for ($i = 0; $i < self::FS_NAME_LEVELS; $i++) {
            $dirName = substr($hash, $i * self::FS_NAME_SYMBOLS_PER_LEVEL, self::FS_NAME_SYMBOLS_PER_LEVEL);
            $path .= $dirName . DIRECTORY_SEPARATOR;
        }

        if (! mkdir(PathManager::getOriginalsPath() . DIRECTORY_SEPARATOR . $path, 0777, true)) {
            throw new \CException('Can\'t create dir');
        }

        $path .= substr($hash, self::FS_NAME_LEVELS * self::FS_NAME_SYMBOLS_PER_LEVEL);

        return $path;
    }

    protected function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if ($this->author_id === null && ! \Yii::app()->user->isGuest) {
                $this->author_id = \Yii::app()->user->id;
            }
        }
        return true;
    }
} 