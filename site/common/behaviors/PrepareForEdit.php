<?php
/**
 * insert Description
 * 
 * @author Alex Kireev <alexk984@gmail.com>
 */

class PrepareForEdit extends CActiveRecordBehavior{

    public $attributes = array();

    public function __get($name)
    {
        if (in_array($name, $this->attributes)) {
                $value = $this->getOwner()->$name;
                return $this->setWidgets($value);
        } else {
            return null;
        }
    }

    private function setWidgets($text)
    {
        return preg_replace_callback('#<!-- widget: (.*) -->(.*)<!-- /widget -->#sU', array($this, 'replaceWidgets'), $text);
    }

    private function replaceWidgets($matches)
    {
        $data = CJSON::decode($matches[1]);
        extract($data);
        if (isset($entity) && isset($entity_id)){
            $model = CActiveRecord::model($entity)->findByPk($entity_id);
            if ($model)
                return $model->getWidget(true, $this->getOwner());
        }
        return '';
    }
} 