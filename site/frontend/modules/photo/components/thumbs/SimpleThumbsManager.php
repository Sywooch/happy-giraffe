<?php
/**
 * Компонент для работы с обычными миниатюрами
 *
 * @author Никита
 * @date 03/10/14
 */

namespace site\frontend\modules\photo\components\thumbs;
use site\frontend\modules\photo\models\Photo;

class SimpleThumbsManager extends ThumbsManager
{
    const HASH_KEY = 'Giraffe.SimpleThumbsManager.hashKey';

    /**
     * @var array конфигурация пресетов
     */
    public $presets;

    public $cacheId = 'apc';

    /**
     * Получить миниатюру фото по заданному имени пресета
     * @param Photo $photo
     * @param $usageName
     * @param bool $replace
     * @return Thumb
     * @throws \CException
     */
    public function getThumb(Photo $photo, $usageName, $replace = false)
    {
        $config = $this->getFilterConfigByUsage($usageName);
        $filter = $this->createFilter($config);
        $path = $this->getFsPath($photo, $usageName);
        return $this->getThumbInternal($photo, $filter, $path, true, $replace);
    }

    public function getThumbByUrl($url)
    {
        $array = explode('/', $url);
        $fsName = implode('/', array_slice($array, -3));
        $hash = $array[count($array) - 4];
        $config = $this->getConfigByHash($hash);
        $filter = $this->createFilter($config);
        $photo = Photo::model()->findByAttributes(array(
            'fs_name' => $fsName
        ));
        $path = 'thumbs/' . $hash . $fsName;
        return $this->getThumbInternal($photo, $filter, $path, true, true);
    }

    /**
     * Создать миниатюры всех доступных пресетов для переданного фото
     * @param Photo $photo
     */
    public function createAll(Photo $photo)
    {
        foreach ($this->presets as $presetName => $config) {
            $this->getThumb($photo, $presetName, true);
        }
    }

    public function hash($config)
    {
        return md5(serialize($config));
    }

    /**
     * Инициализирует класс пресета
     * @param $usageName
     * @return filters\CustomFilterInterface
     * @throws \CException
     */
    protected function createFilter($config)
    {
        $className = '\site\frontend\modules\photo\components\thumbs\filters\\' . ucfirst($config['name']) . 'Filter';
        $params = array_slice($config, 1);
        $reflect  = new \ReflectionClass($className);
        $filter = $reflect->newInstanceArgs($params);
        return $filter;
    }

    protected function getFsPath(Photo $photo, $usageName)
    {
        return 'thumbs/' . $this->getHashByUsage($usageName) . '/' . $photo->fs_name;
    }

    protected function getFilterConfigByUsage($usageName)
    {
        foreach ($this->presets as $preset) {
            if (array_search($usageName, $preset['usages']) !== false) {
                return $preset['filter'];
            }
        }
        throw new \CException('Wrong usage name');
    }

    protected function getHashByUsage($usageName)
    {
        $cache = \Yii::app()->{$this->cacheId};
        $value = $cache->get(self::HASH_KEY . $usageName);
        if ($value === false) {
            $config = $this->getFilterConfigByUsage($usageName);
            $value = $this->hash($config);
            $cache->set(self::HASH_KEY . $usageName, $value);
        }
        return $value;
    }

    protected function getConfigByHash($hash)
    {
        foreach ($this->presets as $preset) {
            if ($this->hash($preset['filter']) == $hash) {
                return $preset['filter'];
            }
        }
        throw new \CException('Wrong hash');
    }
} 