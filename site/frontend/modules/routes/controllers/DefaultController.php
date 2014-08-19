<?php
/**
 * Created by PhpStorm.
 * User: mikita
 * Date: 08/08/14
 * Time: 10:06
 */

class DefaultController extends LiteController
{
    public $layout = '//layouts/lite/main';

    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = Yii::app()->clientScript;
            $cs->registerPackage('lite_routes');
            $cs->useAMD = true;
            return true;
        }
    }

    public function actionIndex()
    {
        $this->pageTitle = $this->meta_description = 'Составь маршрут для автомобиля';
        $this->breadcrumbs = array(
            '<div class="ico-club ico-club__s ico-club__18"></div>' => array('/community/default/club', 'club' => 'auto'),
            'Маршруты',
        );
        $this->render('index');
    }

    /**
     * @sitemap dataSource=sitemapCities
     */
    public function actionCities($letter)
    {
        $dp = Route::getCitiesListDp($letter);

        $this->pageTitle = $this->meta_description = 'Маршруты из городов на букву «' . $letter . '»';
        $this->breadcrumbs = array(
            '<div class="ico-club ico-club__s ico-club__18"></div>' => array('/community/default/club', 'club' => 'auto'),
            'Маршруты' => array('/routes/default/index'),
            $letter,
        );
        $this->render('cities', compact('dp', 'letter'));
    }

    /**
     * @sitemap dataSource=sitemapCity
     */
    public function actionCity($cityId)
    {
        $city = GeoCity::model()->with('region')->findByPk($cityId);
        if ($city === null) {
            throw new CHttpException(404);
        }

        $dp = Route::getCityDp($cityId);

        $this->pageTitle = $this->meta_description = 'Маршруты из города ' . $city->name . ' ' . $city->region->name;
        $this->breadcrumbs = array(
            '<div class="ico-club ico-club__s ico-club__18"></div>' => array('/community/default/club', 'club' => 'auto'),
            'Маршруты' => array('/routes/default/index'),
            'Маршруты города ' . $city->name . ' ' . $city->region->name,
        );
        $this->render('city', compact('dp', 'city'));
    }

    /**
     * @sitemap dataSource=sitemap
     */
    public function actionView($routeId)
    {
        $route = Route::model()->findByPk($routeId);
        if ($route === null) {
            throw new CHttpException(404);
        }

        if ($route->status != Route::STATUS_ROSNEFT_FOUND && $route->status != Route::STATUS_GOOGLE_PARSE_SUCCESS) {
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        }

        if ($route->wordstat_value < Route::WORDSTAT_LIMIT) {
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
        }

        PageView::model()->incViewsByPath($route->url);

        $this->pageTitle = $route->texts['title'];
        $this->meta_description = $route->texts['description'];
        $this->meta_keywords = $route->texts['keywords'];
        $this->breadcrumbs = array(
            '<div class="ico-club ico-club__s ico-club__18"></div>' => array('/community/default/club', 'club' => 'auto'),
            'Маршруты' => array('/routes/default/index'),
            $route->cityFrom->name . ' — ' . $route->cityTo->name,

        );
        $this->render('view', compact('route'));
    }

    public function sitemap($param)
    {
        if ($param == -1) {
            return array();
        }

        $models = Yii::app()->db->createCommand()
            ->select('id')
            ->from(Route::model()->tableName())
            ->where(array('and', 'wordstat_value >= '.Route::WORDSTAT_LIMIT, array('in', 'status', array(Route::STATUS_ROSNEFT_FOUND, Route::STATUS_GOOGLE_PARSE_SUCCESS))))
            ->queryColumn();

        $data = array();
        if ($param == 1)
            $data [] = array(
                'params' => array(
                ),
                'changefreq' => 'weekly',
            );
        foreach ($models as $model) {
            $data[] = array(
                'params' => array(
                    'id' => $model,
                ),
                'changefreq' => 'weekly',
            );
        }

        return $data;
    }

    public function sitemapCity($param)
    {
        if ($param != -1) {
            return array();
        }

        $models = Yii::app()->db->createCommand()
            ->selectDistinct('city_from_id')
            ->from(Route::model()->tableName())
            ->queryColumn();

        return array_map(function($model) {
            return array(
                'params' => array(
                    'cityId' => $model['from_city_id'],
                ),
            );
        }, $models);
    }

    public function sitemapCities($param)
    {
        if ($param != -1) {
            return array();
        }

        return array_map(function($letter) {
            return array(
                'params' => array(
                    'letter' => $letter,
                ),
            );
        }, Route::getRoutesLetters());
    }
} 