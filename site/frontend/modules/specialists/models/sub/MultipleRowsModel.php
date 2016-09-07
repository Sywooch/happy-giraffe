<?php
/**
 * @author Никита
 * @date 25/08/16
 */

namespace site\frontend\modules\specialists\models\sub;


use site\frontend\modules\posts\models\SerializedModel;

class MultipleRowsModel extends SerializedModel
{
    public $models;
    public $modelName;

    public function __construct($data, $owner, $modelName)
    {
        $this->modelName = $modelName;
        parent::__construct($data, $owner);
    }
    
    public function attributeNames()
    {
        return [
            'models',    
        ];
    }
    
    public function serialize()
    {
        return \CJSON::encode(array_map(function(\CModel $model) {
            return $model->attributes;
        }, $this->models));
    }
    
    public function unserialize($data)
    {
        $data = \CJSON::decode($data);
        $this->models = (! $data) ? [] : array_map(function($row) {
            $model = new $this->modelName();
            $model->attributes = $row;
            return $model;
        }, $data);
    }
}