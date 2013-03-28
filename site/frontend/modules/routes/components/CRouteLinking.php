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
     * Загружаем все машруты начиная с самых популярных
     */
    private function loadRoutes()
    {
        $this->routes = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->order('wordstat_value desc')
            ->queryColumn();
    }

    /**
     * Начинаем перелинковку - этап 1
     */
    public function start()
    {
        $this->loadRoutes();

        $index = 0;
        while (true) {
            $this->route = Route::model()->findByPk($this->routes[$index]);
            $index++;

            if ($this->route->inLinksCount > 0){
                continue;
            }

            $this->createRouteLinks();

            if ($index >= count($this->routes))
                break;

            if ($index % 1000 == 0)
                echo round(100 * $index / count($this->routes)) . "\n";
        }
    }

    private function createRouteLinks()
    {
        $this->createCityLinks($this->route->city_from_id);
    }

    /**
     * Создаем ссылки
     * @param $city_id int
     */
    private function createCityLinks($city_id)
    {
        $criteria = new CDbCriteria;
        $criteria->condition = '(
        city_from_id = :city_id AND city_from_out_links_count < 5
        OR
        city_to_id = :city_id AND city_to_out_links_count < 5)
        AND id != :route';
        $criteria->params = array(
            ':city_id' => $city_id,
            ':route' => $this->route->id
        );
        $criteria->order = 'wordstat_value desc';
        $criteria->limit = count($this->getLinks());

        $city_routes = Route::model()->findAll($criteria);

        $anchors = range(0, count($this->getLinks()) - 1);
        shuffle($anchors);
        foreach ($city_routes as $city_route)
            $this->createRouteLink($city_route, array_shift($anchors));
    }

    /*****************************************************************************************************/
    /*********************** Этап перелинковки 2 - ставим ссылки со свободных мест ***********************/
    /*****************************************************************************************************/
    public function startStage2()
    {
        $this->loadRoutes();

        $index = 0;
        while (true) {
            $this->route = Route::model()->findByPk($this->routes[$index]);
            if ($this->route->inLinksCount < count($this->getLinks())) {
                $this->createAnyRouteLinks();
            }

            $index++;
            if ($index >= count($this->routes))
                break;

            if ($index % 1000 == 0)
                echo round(100 * $index / count($this->routes)) . "\n";
        }
    }

    /**
     * Ставим ссылку с любого машрута где можно поставить ссылку
     */
    private function createAnyRouteLinks()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = '(city_from_out_links_count < 5 OR city_to_out_links_count < 5) AND id != :route';
        $criteria->params = array(
            ':route' => $this->route->id
        );
        $criteria->order = 'wordstat_value desc';
        $criteria->limit = count($this->getLinks()) - $this->route->inLinksCount;

        $routes = Route::model()->findAll($criteria);

        $anchors = range(0, count($this->getLinks()) - 1);
        shuffle($anchors);

        foreach ($this->route->inLinks as $link)
            for ($i = 0; $i < count($anchors); $i++)
                if ($anchors[$i] == $link->anchor)
                    unset($anchors[$i]);

        foreach ($routes as $route)
            $this->createRouteLink($route, array_shift($anchors));
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
     * @param $route Route
     */
    public function add($route)
    {
        $this->route = $route;

        //создаем ссылки на маршрут сначала с городами этого машрута
        $this->createCityLinks($this->route->city_from_id);
        //если ссылкок с городов маршрута недостаточно, создаем откуда угодно
        if ($this->route->inLinksCount < count($this->getLinks()))
            $this->createAnyRouteLinks();

        //создаем ссылки с маршрута
    }
}
