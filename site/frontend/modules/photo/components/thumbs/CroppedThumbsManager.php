<?php
/**
 * Компонент для работы с кадрированными фото
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\components\thumbs\filters\core\CropFilter;
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
        $config = $this->presets[$presetName];
        return 'crops/' . md5(serialize($config) . serialize($cropData)) . '/' . $photo->fs_name;
    }
} 