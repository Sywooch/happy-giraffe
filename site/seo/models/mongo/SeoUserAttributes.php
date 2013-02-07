<?php
/**
 * Author: alexk984
 * Date: 18.06.12
 */
class SeoUserAttributes extends EMongoDocument
{
    const ADVERT_ID = 1;

    public $user_id;
    public $attributes;
    private $default = array(
        'last_competitor_site_id_section_1' => 1,
        'last_competitor_site_id_section_2' => 11,
        'last_competitor_site_id_section_3' => 50,
        'wordstat_min' => 500,
        'min_yandex_position' => 10,
        'max_yandex_position' => 100,
        'yandex_traffic' => 1,
        'yandex_sort' => 1,
        'google_visits_min' => 30,
        'se_tab' => 1,
        'import_email_last_user_id'=>0
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo_user_attributes';
    }

    public static function getAttribute($title, $user_id= null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->id;

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

    public static function setAttribute($title, $value, $user_id= null)
    {
        if ($user_id === null)
            $user_id = Yii::app()->user->id;

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