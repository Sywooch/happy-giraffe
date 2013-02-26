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
 * @property integer $out_links_count
 * @property integer $checked
 *
 * The followings are the available model relations:
 * @property RouteLink[] $outLinks
 * @property RouteLink[] $inLinks
 * @property GeoCity $cityFrom
 * @property GeoCity $cityTo
 * @property RoutePoint $points
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
    const STATUS_NO_ROUTE = 12;

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
            'outLinks' => array(self::HAS_MANY, 'RouteLink', 'route_from_id'),
            'points' => array(self::HAS_MANY, 'RoutePoint', 'route_id'),
            'outLinksCount' => array(self::STAT, 'RouteLink', 'route_from_id'),
            'inLinksCount' => array(self::STAT, 'RouteLink', 'route_to_id'),
            'cityFrom' => array(self::BELONGS_TO, 'GeoCity', 'city_from_id'),
            'cityTo' => array(self::BELONGS_TO, 'GeoCity', 'city_to_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'city_from_id' => 'Из города',
            'city_to_id' => 'В город',
            'wordstat_value' => 'Wordstat',
            'distance' => 'Расстояние',
            'status' => 'Статус',
            'checked' => 'Перейти',
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('city_from_id', $this->city_from_id, true);
        $criteria->compare('city_to_id', $this->city_to_id, true);
        $criteria->compare('wordstat_value', $this->wordstat_value);
        $criteria->compare('distance', $this->distance);
        $criteria->compare('status', $this->status);
        $criteria->compare('city_from_out_links_count', $this->city_from_out_links_count);
        $criteria->compare('city_to_out_links_count', $this->city_to_out_links_count);
        $criteria->compare('checked', $this->checked);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 100),
            'sort' => array('defaultOrder' => 'id DESC')
        ));
    }

    public function getTextStatus()
    {
        switch ($this->status) {
            case self::STATUS_NEW:
                return 'Новый';
            case self::STATUS_PARSING:
                return 'парсится';
            case self::STATUS_ROSNEFT_FOUND:
                return 'спарсен с Роснефти';
            case self::STATUS_ROSNEFT_NOT_FOUND:
                return 'не найден на Роснефти';
            case self::STATUS_GOOGLE_PARSE_SUCCESS:
                return 'спарсен с гугла';
            case self::STATUS_ZERO_RESULT:
                return 'Google Maps API возвратил код ZERO_RESULT';
            case self::STATUS_NOT_FOUND:
                return 'Google Maps API возвратил код NOT_FOUND';
            case self::STATUS_NOT_FOUND:
                return 'Другая ошибка при поиске маршрута';
        }

        return 'статус не определен';
    }

    public function getRouteLink()
    {
        return CHtml::link('перейти', Yii::app()->createAbsoluteUrl('/routes/default/index', array('id'=>$this->id), array('target' => '_blank')));
    }

    /**
     * Создаем новый маршрут
     *
     * @param $city_from GeoCity
     * @param $city_to GeoCity
     * @return Route|null
     */
    public static function createNewRoute($city_from, $city_to)
    {
        $route = new Route();
        $route->city_from_id = $city_from->id;
        $route->city_to_id = $city_to->id;
        $route->save();

        $success = GoogleRouteParser::parseRoute($route);
        if ($success)
            $route->createReturnRoute();
        $linking = new CRouteLinking;
        $linking->add($route);

        return $route;
    }

    public function createReturnRoute()
    {
        //если обратный маршрут не существует
        if (Route::model()->findByAttributes(array('city_from_id' => $this->city_to_id, 'city_to_id' => $this->city_from_id)) === null) {
            //создаем обратный маршрут
            $route = new Route();
            $route->city_from_id = $this->city_to_id;
            $route->city_to_id = $this->city_from_id;
            $route->wordstat_value = $this->wordstat_value;
            $route->distance = $this->distance;
            $route->status = $this->status;
            $route->save();

            //копируем промежуточный пункты
            $criteria = new CDbCriteria;
            $criteria->compare('route_id', $this->id);
            $criteria->order = 'id desc';
            $points = RoutePoint::model()->findAll($criteria);
            foreach ($points as $key => $point) {
                if (isset($points[$key + 1]))
                    $next_point = $points[$key + 1];
                else
                    $next_point = null;

                $new_point = new RoutePoint();
                $new_point->route_id = $route->id;

                if ($next_point !== null) {
                    $new_point->name = $next_point->name;
                    $new_point->region_id = $next_point->region_id;
                    $new_point->city_id = $next_point->city_id;
                } else {
                    $new_point->name = $route->cityTo->name;
                    $new_point->region_id = $route->cityTo->region_id;
                    $new_point->city_id = $route->city_to_id;
                }

                $new_point->distance = $point->distance;
                $new_point->time = $point->time;
                $new_point->save();
            }

            return $route;
        }

        return null;
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
            if (empty($point->city_id) || !$point->uniqueCityInRegion()) {
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
                0 => 'Маршрут ' . $city1[0] . '-' . $city2[0],
                1 => 'Узнайте, как доехать на авто от ' . $city1[1] . ' до ' . $city2[1] . '. Схема трассы ' . $city1[0] . '-' . $city2[0] . ' на карте. Выбирайте нужные вам дороги, трассы, шоссе и магистрали на пути от ' . $city1[1] . ' до ' . $city2[1],
                2 => 'Пункты следования на пути ' . $city1[0] . '-' . $city2[0],
                3 => 'Расстояние между ' . $city1[2] . ' и ' . $city2[2],
                4 => 'Столько километров от ' . $city1[1] . ' до ' . $city2[1] . ' на автомобиле',
                5 => 'Время в пути от ' . $city1[1] . ' до ' . $city2[1],
                6 => 'Столько времени ехать от ' . $city1[1] . ' до ' . $city2[1],
                7 => 'Отправьте маршрут поездки ' . $city1[0] . '-' . $city2[0] . ' своим друзьям',
                8 => 'Отзывы водителей о состоянии трассы ' . $city1[0] . '-' . $city2[0],
                'title' => 'Маршрут ' . $city1[0] . '-' . $city2[0].'. Расстояние между ' . $city1[2] . ' и ' . $city2[2].' – '.$this->distance.' км.',
                'description' => 'Как доехать от ' . $city1[1] . ' до ' . $city2[1] . '. Расчет расстояния и расход горючего.',
                'keywords' => 'Маршрут между городами, расстояние, расход горючего, '.$city1[0].', '.$city2[0].'.',
            );
        else
            return array(
                0 => 'Маршрут ' . $city1[0] . '-' . $city2[0],
                1 => 'Изучайте карту маршрута ' . $city1[0] . '-' . $city2[0] . ' и узнавайте, как преодолеть это расстояние на машине. Смотрите лучшие автотрассы и дороги от ' . $city1[1] . ' до ' . $city2[1],
                2 => 'Населенные пункты и другие объекты на автодороге ' . $city1[0] . '-' . $city2[0],
                3 => 'Сколько километров от ' . $city1[1] . ' до ' . $city2[1],
                4 => 'Количество км от ' . $city1[1] . ' до ' . $city2[1],
                5 => 'Сколько времени ехать от ' . $city1[1] . ' до ' . $city2[1],
                6 => 'Время, проведенное в пути',
                7 => 'Делитесь маршрутом поездки ' . $city1[0] . '-' . $city2[0] . ' со своими друзьям',
                8 => 'Водители рассказывают, как доехать от ' . $city1[1] . ' до ' . $city2[1],
                'title' => 'Маршрут ' . $city1[0] . '-' . $city2[0].'. Расстояние между ' . $city1[2] . ' и ' . $city2[2].' – '.$this->distance.' км.',
                'description' => 'Как доехать от ' . $city1[1] . ' до ' . $city2[1] . '. Расчет расстояния и расход горючего.',
                'keywords' => 'Маршрут между городами, расстояние, расход горючего, '.$city1[0].', '.$city2[0].'.',
            );
    }

    public function getUrl($absolute = false)
    {
        $method = $absolute ? 'createAbsoluteUrl' : 'createUrl';
        return Yii::app()->$method('/routes/default/index', array('id' => $this->id));
    }

    /**
     * @return array
     */
    public function getOrderedLinks()
    {
        $list1 = array();
        $list2 = array();
        $list3 = array();

        foreach ($this->outLinks as $link) {
            if ($link->routeTo->city_from_id == $this->city_from_id)
                $list1 [] = $link;
            elseif ($link->routeTo->city_from_id == $this->city_to_id)
                $list2 [] = $link; else
                $list3 [] = $link;
        }

        while (count($list1) < 5) {
            if (count($list3) > 0) {
                $link = array_shift($list3);
                $list1 [] = $link;
            } else
                break;
        }

        while (count($list2) < 5) {
            if (count($list3) > 0) {
                $link = array_shift($list3);
                $list2 [] = $link;
            } else
                break;
        }

        return array($list1, $list2);
    }

    public static function get8Points($points)
    {
        if (count($points) <= 8)
            return $points;

        $step = (count($points) / 8);

        $result = array();
        for($i=0;$i<8;$i++){
            $index = round($step*$i);
            $result[] = $points[$index];
        }

        return $result;
    }
}