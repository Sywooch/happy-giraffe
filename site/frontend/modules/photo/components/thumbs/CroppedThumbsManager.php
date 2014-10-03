<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 26/09/14
 * Time: 02:53 PM
 */

namespace site\frontend\modules\photo\components\thumbs;


use site\frontend\modules\photo\components\thumbs\filters\CropFilter;
use site\frontend\modules\photo\components\thumbs\ThumbsManager;
use site\frontend\modules\photo\models\Photo;


class CroppedThumbsManager extends ThumbsManager
{
    public $presets;

    public function getCrop(Photo $photo, $presetName, $cropData, $replace = false)
    {
        $filter = $this->createFilter($presetName, $cropData);
        $thumb = $this->getThumbInternal($photo, $filter, $this->getFsPath($photo, $presetName, $cropData), false, $replace);
        return $thumb;
    }

    protected function createFilter($presetName, $cropData)
    {
        if (! array_key_exists($presetName, $this->presets)) {
            throw new \CException('Неизвестное имя пресета');
        }
        $config = $this->presets[$presetName];

        $filter = new CropFilter($cropData, $config['width'], $config['height']);
        return $filter;
    }

    protected function getFsPath(Photo $photo, $presetName, $cropData)
    {
        $fsName = substr_replace($photo->fs_name, '_' . implode('x', $cropData), strrpos($photo->fs_name, '.'), 0);
        return 'crops/' . $presetName . '/' . $fsName;
    }
} 