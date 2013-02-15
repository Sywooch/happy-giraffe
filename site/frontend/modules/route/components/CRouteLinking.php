<?php
/**
 * Author: alexk984
 * Date: 18.01.13
 */
class CRouteLinking
{
    const LINKS_LIMIT = 10;

    const WORDSTAT_LEVEL_1 = 2;
    const WORDSTAT_LEVEL_2 = 20;

    /**
     * @var CRouteLinking
     */
    protected static $instance = null;
    public $routes;
    /**
     * @var Route
     */
    public $route;

    public $links1 = array(
        'Расстояние между {city_from2} и {city_to2} на машине',
        'Сколько километров от {city_from1} до {city_to1}',
        'Как доехать от {city_from1} до {city_to1}',
        'Карта и схема трассы {city_from}-{city_to}',
        'Дорога на авто от {city_from1} до {city_to1}',
        'Сколько км от {city_from1} до {city_to1}',
        'Проложите маршрут от {city_from1} до {city_to1}'
    );

    public $links2 = array(
        'Расстояние между {city_from2} и {city_to2} на машине',
        'Сколько километров от {city_from1} до {city_to1}',
        'Как доехать от {city_from1} до {city_to1}',
        'Карта и схема трассы {city_from}-{city_to}',
        'Дорога на авто от {city_from1} до {city_to1}',
        'Сколько км от {city_from1} до {city_to1}',
        'Проложите маршрут от {city_from1} до {city_to1}',
        'Путь {city_from}-{city_to} на автомобиле',
        'Сколько ехать от {city_from1} до {city_to1}',
        'Состояние и отзывы о трассе {city_from}-{city_to}'
    );

    public $links3 = array(
        'Расстояние от {city_from1} до {city_to1}',
        'Расстояние между {city_from2} и {city_to2}',
        'Расстояние на машине от {city_from1} до {city_to1}',
        'Сколько ехать от {city_from1} до {city_to1}',
        'Автодорога от {city_from1} до {city_to1}',
        'Сколько километров от {city_from1} до {city_to1}',
        'Как доехать от {city_from1} до {city_to1}',
        'Узнайте расстояние между {city_from2} и {city_to2}',
        'Как доехать от {city_from1} до {city_to1} на автомобиле',
        'Дорога от {city_from1} до {city_to1} на авто',
        'Автодорога {city_from}-{city_to}',
        'Дорога от {city_from1} до {city_to1}',
        'Автотрасса от {city_from1} до {city_to1}',
        'Отзывы о трассе {city_from}-{city_to}',
        'Трасса {city_from}-{city_to}',
        'Шоссе {city_from}-{city_to}',
        'Состояние трассы {city_from}-{city_to}',
        'Карта трассы {city_from}-{city_to}',
        'Схема трассы {city_from}-{city_to}',
        'Магистраль {city_from}-{city_to}',
        'Путь от {city_from1} до {city_to1}',
        'Маршрут от {city_from1} до {city_to1}',
        'Проложите маршрут от {city_from1} до {city_to1}',
        'Карта {city_from}-{city_to}',
        'Сколько километров от {city_from1} до {city_to1} на авто',
        'Время в пути от {city_from1} до {city_to1}',
        'Поездка в {city_from} из {city_to1}',
        'Пробки на дороге {city_from}-{city_to}',
        'Расход топлива {city_from}-{city_to} '
    );

    /**
     * @return CRouteLinking
     */
    public static function model()
    {
        if (!isset(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * Start linking
     */
    public function start()
    {
        $this->loadRoutes();

        $index = 0;
        while (true) {
            $this->route = Route::model()->findByPk($this->routes[$index]);
            $this->createRouteLinks();

            $index++;
            if ($index >= count($this->routes))
                break;
        }
    }

    /**
     * load all routes
     */
    private function loadRoutes()
    {
        $this->routes = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->order('wordstat_value desc')
            ->queryColumn();
    }

    private function createRouteLinks()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = '(city_from_id = :city1_id
        OR city_to_id = :city1_id
        OR city_from_id = :city2_id
        OR city_to_id = :city2_id)
        AND id != :route
        AND out_links_count < 10
        ';
        $criteria->params = array(
            ':city1_id' => $this->route->city_from_id,
            ':city2_id' => $this->route->city_to_id,
            ':route' => $this->route->id
        );
        $criteria->order = 'wordstat_value desc';
        $criteria->limit = count($this->getLinks());

        $city_routes = Route::model()->findAll($criteria);

        $anchors = range(0, count($this->getLinks()) - 1);
        shuffle($anchors);
        foreach ($city_routes as $city_route) {
            $this->createRouteLink($city_route, array_shift($anchors));
        }
    }

    /**
     * Создать ссылка с переданного машрута на текущий маршрут
     *
     * @param Route $route маршрут с которого можно поставить ссылку
     * @param $anchor_id анкор для ссылки
     * @return int
     */
    private function createRouteLink($route, $anchor_id)
    {
        $link = new RouteLink;
        $link->route_from_id = $route->id;
        $link->route_to_id = $this->route->id;
        $link->anchor = $anchor_id;
        $link->save();
    }

    /**
     * @return array
     */
    public function getLinks()
    {
        if ($this->route->wordstat_value > self::WORDSTAT_LEVEL_2)
            return $this->links3;
        if ($this->route->wordstat_value > self::WORDSTAT_LEVEL_1)
            return $this->links2;

        return $this->links1;
    }

    /**
     * If link from current route to other does not exist returns true
     *
     * @param $route_id
     * @return bool
     */
    private function linkNotExist($route_id)
    {
        return RouteLink::model()->findByAttributes(array(
            'route_from_id' => $this->route->id,
            'route_to_id' => $route_id)) === null;
    }


    /**
     * Метод для расчета пограничных значений частоты wordstat
     */
    public function showCounts()
    {
        $all = 0;

        $count_max = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('routes__routes')
            ->where('wordstat_value > ' . self::WORDSTAT_LEVEL_2)
            ->queryScalar();
        echo $count_max . ' - ' . ($count_max * 29) . "\n";
        $all += $count_max * 29;

        $count_mid = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('routes__routes')
            ->where('wordstat_value > ' . self::WORDSTAT_LEVEL_1 . ' AND wordstat_value <= ' . self::WORDSTAT_LEVEL_2)
            ->queryScalar();
        echo $count_mid . ' - ' . ($count_mid * 10) . "\n";
        $all += $count_mid * 10;

        $count_min = Yii::app()->db->createCommand()
            ->select('count(*)')
            ->from('routes__routes')
            ->where('wordstat_value <= ' . self::WORDSTAT_LEVEL_1)
            ->queryScalar();
        echo $count_min . ' - ' . ($count_min * 7) . "\n";
        $all += $count_min * 7;

        echo $all / 10;
    }

    //*****************************************************************************************************************/
    /********************************************** Add new route linking *********************************************/
    /******************************************************************************************************************/
    /**
     * Add new route to current linking system
     *
     * @param $route_id
     */
    public function add($route_id)
    {
        $this->route = Route::model()->findByPk($route_id);

        //create links from this route
        $this->createRouteLinks($this->route->city_from_id);
        echo '<br>';
        $this->createRouteLinks($this->route->city_to_id);

        //create link to this route
        $this->createLinksToRoute($this->route->city_from_id);
        $this->createLinksToRoute($this->route->city_to_id);
    }

    /**
     * create input links to new route
     */
    private function createLinksToRoute($city_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = '(city_from_id = :city_id OR city_to_id = :city_id) AND id != :route';
        $criteria->params = array(':city_id' => $city_id, ':route' => $this->route->id);
        $routes = Route::model()->findAll($criteria);

        foreach ($routes as $route) {

            //if route has empty place - placing link there
            if ($route->outLinksCount < self::LINKS_LIMIT) {
                $keyword = $this->getAnchor($route->id);
                if ($keyword === null)
                    return;

                $this->createLink($route->id, $this->route->id, $keyword);
            }
        }
    }
}
