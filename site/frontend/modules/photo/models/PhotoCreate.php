<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 09/06/14
 * Time: 18:57
 */

namespace site\frontend\modules\photo\models;


class PhotoCreate extends Photo
{
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
                copy($this->path, $this->getOriginalPath());
                $this->save();
            }
        } catch (\Exception $e) {
            $this->addError('path', 'Некорректный файл изображения');
        }
    }

    protected function generateFsName()
    {
        $hash = md5(uniqid($this->original_name . microtime(), true));
        $hash = substr_replace($hash, '/', 2, 0);
        if (! is_dir())
        $hash = substr_replace($hash, '/', 5, 0);
        return $hash;
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