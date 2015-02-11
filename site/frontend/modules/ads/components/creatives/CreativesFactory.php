<?php
/**
 * @author Никита
 * @date 10/02/15
 */

namespace site\frontend\modules\ads\components\creatives;


class CreativesFactory extends \CApplicationComponent
{
    public $presets;

    public function create($presetName, $modelPk, $properties = array())
    {
        if (! isset($this->presets[$presetName])) {
            throw new \CException('Пресет не определен');
        }
        $config = $this->presets[$presetName];
        if (! isset($config['class'])) {
            throw new \CException('В конфигурации пресета должен быть определен параметр class');
        }
        $class = $config['class'];
        unset($config['class']);
        /** @var \site\frontend\modules\ads\components\creatives\BaseCreative $renderer */
        $renderer = new $class();
        $renderer->presetName = $presetName;
        $renderer->model = \CActiveRecord::model($renderer->modelClass)->findByPk($modelPk);
        $properties = \CMap::mergeArray($config, $properties);
        foreach ($properties as $name => $value) {
            $renderer->$name = $value;
        }
        $renderer->init();
        return $renderer;
    }
}