<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class Config extends EMongoDocument
{
    public $attributes;
    private $default = array(
        'minClicks'=>4,
        'stop_threads'=>0,
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo_config';
    }

    public static function getAttribute($title){
        $model = self::model()->find();
        if ($model !== null){
            if (isset($model->attributes[$title])){
                return $model->attributes[$title];
            }
        }else{
            $model = new Config;
            $model->attributes = array();
            $model->save();
        }

        if (isset($model->default[$title]))
            return $model->default[$title];

        return null;
    }

    public static function setAttribute($title, $value){
        $model = self::model()->find();
        if ($model === null){
            $model = new Config;
            $model->attributes = array();
        }

        $model->attributes[$title] = $value;
        $model->save();
    }
}