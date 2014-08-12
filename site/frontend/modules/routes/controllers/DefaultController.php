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
        $this->meta_title = 'Составь маршрут для автомобиля';
        $this->render('index');
    }

    public function actionCities($letter)
    {
        $dp = Route::getCitiesListDp($letter);
        $this->render('cities', compact('dp', 'letter'));
    }

    public function actionCity($cityId)
    {
        $city = GeoCity::model()->with('region')->findByPk($cityId);
        if ($city === null) {
            throw new CHttpException(404);
        }

        $dp = Route::getCityDp($cityId);
        $this->render('city', compact('dp', 'city'));
    }

    public function actionView($routeId)
    {
        $route = Route::model()->findByPk($routeId);
        if ($route === null) {
            throw new CHttpException(404);
        }

        if ($route->wordstat_value < Route::WORDSTAT_LIMIT)
            Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

        if ($route->status != Route::STATUS_ROSNEFT_FOUND && $route->status != Route::STATUS_GOOGLE_PARSE_SUCCESS)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        PageView::model()->incViewsByPath($route->url);

        $this->pageTitle = $route->texts['title'];
        $this->meta_description = $route->texts['description'];
        $this->meta_keywords = $route->texts['keywords'];
        $this->render('view', compact('route'));
    }

    public function sitemap($param)
    {
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
} 