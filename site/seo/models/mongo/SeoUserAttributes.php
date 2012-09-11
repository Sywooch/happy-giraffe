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
        'last_competitor_site_id_section_1' => 1,
        'last_competitor_site_id_section_2' => 11,
        'wordstat_min' => 500,
        'min_yandex_position' => 10,
        'max_yandex_position' => 100,
        'yandex_traffic' => 1,
        'yandex_sort' => 1,
        'google_visits_min' => 30,
        'links_count' => 0,
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo_user_attributes';
    }

    public static function getAttribute($user_id, $title)
    {
        $model = self::model()->findByAttributes(array(
            'user_id' => (int)$user_id
        ));

        if ($model !== null) {
            if (isset($model->attributes[$title])) {
                return $model->attributes[$title];
            }
        } else {
            $model = new SeoUserAttributes;
            $model->user_id = (int)$user_id;
            $model->attributes = array();
            $model->save();
        }

        if (isset($model->default[$title]))
            return $model->default[$title];

        return null;
    }

    public static function setAttribute($user_id, $title, $value)
    {
        $model = self::model()->findByAttributes(array(
            'user_id' => (int)$user_id
        ));
        if ($model === null) {
            $model = new SeoUserAttributes;
            $model->user_id = (int)$user_id;
            $model->attributes = array();
        }

        $model->attributes[$title] = $value;
        $model->save();
    }
}