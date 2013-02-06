<?php
/**
 * Author: alexk984
 * Date: 18.01.13
 */
class CRouteLinking
{
    const LINKS_LIMIT = 10;

    /**
     * @var CRouteLinking
     */
    protected static $instance = null;

    public $route_index = 0;
    public $routes;
    /**
     * @var Route
     */
    public $route;

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

        while (true) {
            $this->nextRoute();

            $this->createRouteLinks($this->route->city_from_id);
            $this->createRouteLinks($this->route->city_to_id);

            $this->route_index++;
            if ($this->route_index >= count($this->routes))
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
            ->order('wordstat desc')
            ->queryColumn();
    }

    /**
     * Load next route
     */
    private function nextRoute()
    {
        $this->route = Route::model()->findByPk($this->routes[$this->route_index]);

        echo $this->route->id . ': ' . $this->route->cityFrom->name . ' - ' . $this->route->cityTo->name . ' <<' . $this->route->wordstat . '>> <br>';
    }

    /**
     * Create output links from route with the city
     *
     * @param $city_id
     */
    private function createRouteLinks($city_id)
    {
        $city_routes = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->where('(city_from_id = :city_id OR city_to_id = :city_id) AND id != :route',
            array(
                ':city_id' => $city_id,
                ':route' => $this->route->id
            ))
            ->order('wordstat desc')
            ->queryColumn();

        echo 'City: ' . $city_id . '<br>';
        print_r($city_routes);
        echo '<br>';

        $link_count = $this->createCityLinks($city_routes, 5);
        echo $link_count . '<br>';

        if ($link_count < 5 && count($city_routes) >= 5)
            $this->createCityLinks($city_routes, 5 - $link_count, true);
    }

    /**
     * Create links with the city of route
     *
     * @param array $city_routes possible routes ids
     * @param int $links_count_needed how much links can we create
     * @param bool $used
     * @return int
     */
    private function createCityLinks($city_routes, $links_count_needed, $used = false)
    {
        $link_count = 0;
        foreach ($city_routes as $route_id) {
            $link_count += $this->createSomeLink($route_id, $used);

            if ($link_count == $links_count_needed)
                break;
        }

        return $link_count;
    }

    /**
     * Create link from current route to other if it is possible
     *
     * @param $route_id
     * @param bool $used can we use already used keywords
     * @return int
     */
    private function createSomeLink($route_id, $used = false)
    {
        $route = Route::model()->findByPk($route_id);
        echo $route->id . ': ' . $route->cityFrom->name . ' - ' . $route->cityTo->name . ' <<' . $route->wordstat . '>> <br>';

        $keyword = $this->getAnchor($route_id, $used);
        var_dump($keyword);

        if ($keyword !== null && $this->linkNotExist($route_id)) {
            echo $keyword->id . ' ' . $keyword->text . ' <<' . $keyword->wordstat . '>> <br>';

            if ($this->createLink($this->route->id, $route_id, $keyword))
                return 1;
        }

        return 0;
    }

    /**
     * @param $route_id
     * @param bool $used
     * @return RouteKeyword
     */
    private function getAnchor($route_id, $used = false)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('route_id', $route_id);
        if ($used === false) {
            $criteria->compare('used', 0);
            $criteria->order = 'wordstat desc';
        } else {
            $criteria->order = 'used asc, wordstat desc';
        }
        return RouteKeyword::model()->find($criteria);
    }

    /**
     * Creates link
     *
     * @param int $r1 route from
     * @param int $r2 route to
     * @param RouteKeyword $keyword
     * @return int
     */
    private function createLink($r1, $r2, $keyword)
    {
        $link = new RouteLink;
        $link->route_from_id = $r1;
        $link->route_to_id = $r2;
        $link->keyword = $keyword->text;
        if ($link->save()) {
            $keyword->used++;
            $keyword->update(array('used'));
            return 1;
        }

        return 0;
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
