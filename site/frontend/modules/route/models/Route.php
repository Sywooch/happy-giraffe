<?php

/**
 * This is the model class for table "routes__routes".
 *
 * The followings are the available columns in table 'routes__routes':
 * @property string $id
 * @property string $city_from_id
 * @property string $city_to_id
 * @property integer $wordstat_value
 * @property integer $distance
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property RouteLink[] $outLinks
 * @property RouteLink[] $inLinks
 * @property GeoCity $cityFrom
 * @property GeoCity $cityTo
 */
class Route extends CActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_PARSING = 1;
    const STATUS_ROSNEFT_FOUND = 2;
    const STATUS_ROSNEFT_NOT_FOUND = 3;
    const STATUS_GOOGLE_PARSE_SUCCESS = 4;

    /**
     * Google can't find this route
     */
    const STATUS_ZERO_RESULT = 10;
    const STATUS_NOT_FOUND = 11;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Route the static model class
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
        return 'routes__routes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_from_id, city_to_id', 'required'),
            array('wordstat_value', 'numerical', 'integerOnly' => true),
            array('city_from_id, city_to_id', 'length', 'max' => 11),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, city_from_id, city_to_id, wordstat_value', 'safe', 'on' => 'search'),
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
            'inLinks' => array(self::HAS_MANY, 'RouteLink', 'route_to_id'),
            'outLinks' => array(self::HAS_MANY, 'RouteLink', 'route_from_id', 'order' => 'created asc'),
            'outLinksCount' => array(self::STAT, 'RouteLink', 'route_from_id'),
            'cityFrom' => array(self::BELONGS_TO, 'GeoCity', 'city_from_id'),
            'cityTo' => array(self::BELONGS_TO, 'GeoCity', 'city_to_id'),
        );
    }

    /**
     * Создаем новый маршрут
     *
     * @param $city_from GeoCity
     * @param $city_to GeoCity
     */
    public static function createNewRoute($city_from, $city_to)
    {
        $route = new Route();
        $route->city_from_id = $city_from->id;
        $route->city_to_id = $city_to->id;
        $route->save();

        GoogleRouteParser::parseRoute($route);

        return $route;
    }

    /**
     * @return array
     */
    public function getIntermediatePoints()
    {
        $result = array(array(
            'city' => $this->cityFrom,
            'time' => '00:00',
            'summary_time' => '00:00',
            'distance' => 0,
            'summary_distance' => 0,
            'num' => 0
        ));
        $points = RoutePoint::model()->findAll(array('order' => 'id', 'condition' => 'route_id=' . $this->id));

        $speed = 80;
        $next_point_distance = 0;
        $summary_distance = 0;
        $num = 1;
        foreach ($points as $point) {
            $summary_distance += $point->distance;
            //пропускаем населенные пункты, которых нет в нашей базе
            //это скорее всего названия трасс, которые мы не сможет отметить на карте метками
            if (empty($point->city_id)) {
                $next_point_distance += $point->distance;
            } else {
                $next_point_distance += $point->distance;
                $result [] = array(
                    'city' => $point->city,
                    'time' => $this->formatTime(round($next_point_distance / $speed * 60)),
                    'summary_time' => $this->formatTime(round($summary_distance / $speed * 60)),
                    'distance' => $next_point_distance,
                    'summary_distance' => $summary_distance,
                    'num' => $num
                );

                $next_point_distance = 0;
                $num++;
            }
        }

        return $result;
    }

    public function formatTime($minutes)
    {
        $hours = floor($minutes / 60);
        $minutes = $minutes - $hours * 60;

        return sprintf('%02d:%02d', $hours, $minutes);
    }

    public function getTexts()
    {
        $city1 = array($this->cityFrom->name, $this->cityFrom->name_from, $this->cityFrom->name_between);
        $city2 = array($this->cityTo->name, $this->cityTo->name_from, $this->cityTo->name_between);
        if ($this->city_from_id > $this->city_to_id)
            return array(
                'Маршрут ' . $city1[0] . '-' . $city2[0],
                'Узнайте, как доехать на авто от ' . $city1[1] . ' до ' . $city2[1] . '. Схема трассы ' . $city1[0] . '-' . $city2[0] . ' на карте. Выбирайте нужные вам дороги, трассы, шоссе и магистрали на пути от ' . $city1[1] . ' до ' . $city2[1],
                'Пункты следования на пути ' . $city1[0] . '-' . $city2[0],
                'Расстояние между ' . $city1[2] . ' и ' . $city2[2],
                'Столько километров от ' . $city1[1] . ' до ' . $city2[1] . ' на автомобиле',
                'Время в пути от ' . $city1[1] . ' до ' . $city2[1],
                'Столько времени ехать от ' . $city1[1] . ' до ' . $city2[1],
                'Отправьте маршрут поездки ' . $city1[0] . '-' . $city2[0] . ' своим друзьям',
                'Отзывы водителей о состоянии трассы ' . $city1[0] . '-' . $city2[0],
            );
        else
            return array(
                'Маршрут ' . $city1[0] . '-' . $city2[0],
                'Изучайте карту маршрута ' . $city1[0] . '-' . $city2[0] . ' и узнавайте, как преодолеть это расстояние на машине. Смотрите лучшие автотрассы и дороги от ' . $city1[1] . ' до ' . $city2[1],
                'Населенные пункты и другие объекты на автодороге ' . $city1[0] . '-' . $city2[0],
                'Сколько километров от ' . $city1[1] . ' до ' . $city2[1],
                'Количество км от ' . $city1[1] . ' до ' . $city2[1],
                'Сколько времени ехать от ' . $city1[1] . ' до ' . $city2[1],
                'Время, проведенное в пути',
                'Делитесь маршрутом поездки ' . $city1[0] . '-' . $city2[0] . ' со своими друзьям',
                'Водители рассказывают, как доехать от ' . $city1[1] . ' до ' . $city2[1],
            );
    }

    public function getUrl($absolute = false)
    {
        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method('/route/default/index', array('id' => $this->id));
    }
}