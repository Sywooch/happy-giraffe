<?php

/**
 * This is the model class for table "routes__coordinates".
 *
 * The followings are the available columns in table 'routes__coordinates':
 * @property double $lat
 * @property double $lng
 * @property string $city_id
 *
 * The followings are the available model relations:
 * @property GeoCity $city
 */
class RouteCoordinates extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RouteCoordinates the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'routes__coordinates';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('lat, lng', 'required'),
            array('lat, lng', 'numerical'),
            array('city_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, lat, lng, city_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'city' => array(self::BELONGS_TO, 'GeoCity', 'city_id'),
        );
    }

    /**
     * @param $lat
     * @param $lng
     * @return bool|null|int
     */
    public static function getCity($lat, $lng)
    {
        $lat = sprintf('%.3f', round($lat, 3));
        $lng = sprintf('%.3f', round($lng, 3));

        $model = self::model()->find('lat=' . $lat . ' AND lng=' . $lng);
        if ($model === null){
//            echo "coordinates not found in db\n";
            return false;
        }

//        echo "coordinates found in db\n";

        if (empty($model->city_id))
            return null;
        return GeoCity::model()->findByPk($model->city_id);
    }

    /**
     * @param $lat float
     * @param $lng float
     * @param $city GeoCity|null
     */
    public static function saveCoordinates($lat, $lng, $city)
    {
        $lat = round($lat, 3);
        $lng = round($lng, 3);

        $model = new RouteCoordinates();
        $model->lat = $lat;
        $model->lng = $lng;
        if (!empty($city))
            $model->city_id = $city->id;
        try {
            $model->save();
        } catch (Exception $err) {
        }
    }
}