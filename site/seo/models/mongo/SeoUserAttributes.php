<?php
/**
 * Author: alexk984
 * Date: 18.06.12
 */
class SeoUserAttributes extends EMongoDocument
{
    public $user_id;
    public $attributes;
    private $default = array(
        'last_competitor_site_id'=>1
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo_user_attributes';
    }

    public static function getAttribute($user_id, $title){
        $model = self::model()->findByAttributes(array(
            'user_id' => (int)$user_id
        ));

        if ($model !== null){
            if (isset($model->attributes[$title])){
                return $model->attributes[$title];
            }
        }else{
            $model = new SeoUserAttributes;
            $model->user_id = (int)$user_id;
            $model->attributes = array();
            $model->save();
        }

        if (isset($model->default[$title]))
            return $model->default[$title];

        return null;
    }

    public static function setAttribute($user_id, $title, $value){
        $model = self::model()->findByAttributes(array(
            'user_id' => (int)$user_id
        ));
        if ($model === null){
            $model = new SeoUserAttributes;
            $model->user_id = (int)$user_id;
            $model->attributes = array();
        }

        $model->attributes[$title] = $value;
        $model->save();
    }
}