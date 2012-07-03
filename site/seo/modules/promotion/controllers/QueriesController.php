<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class QueriesController extends SController
{
    public $secret_key = 'kastgpij35iyiehi';
    public $pageTitle = 'продвижение';
    public $layout = '//layouts/promotion';

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action)
    {
        if ($action->id == 'startThread')
            return true;

        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionAdmin($period = 1, $sort = 'yandex_visits')
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('phrases');
        $criteria->together = true;
        if ($period == 2)
            $criteria->condition = 'keyword_id IS NOT NULL AND (yandex_month_visits != 0 OR google_month_visits != 0 )';
        else
            $criteria->condition = 'keyword_id IS NOT NULL AND (yandex_week_visits != 0 OR google_week_visits != 0 )';

        if ($sort == 'yandex_visits' && $period == 1) {
            $criteria->order = 'yandex_week_visits DESC';
        } elseif ($sort == 'google_visits' && $period == 1) {
            $criteria->order = 'google_week_visits DESC';
        }
        elseif ($sort == 'yandex_visits' && $period == 2) {
            $criteria->order = 'yandex_month_visits DESC';
        }
        elseif ($sort == 'google_visits' && $period == 2) {
            $criteria->order = 'google_month_visits DESC';
        }
        else
            $criteria->order = $sort . ' ASC';

        $count = Page::model()->count($criteria);
        $pages = new CPagination($count);
        $pages->setPageSize(100);
        $pages->applyLimit($criteria);

        $models = Page::model()->findAll($criteria);
        $this->render('admin', compact('models', 'pages', 'period'));
    }

    public function actionParse()
    {
        $metrica = new YandexMetrica();
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();

        $response = array(
            'status' => true,
            'count' => Query::model()->count()
        );

        echo CJSON::encode($response);
    }

    public function actionSearch()
    {
        Config::setAttribute('stop_threads', 0);

        for ($i = 0; $i < 100; $i++) {
            $ch = curl_init('http://seo.happy-giraffe.com/queries/startThread?se=2&secret_key=' . $this->secret_key);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            $result = curl_exec($ch);
//            echo $result;
        }

        for ($i = 0; $i < 100; $i++) {
            $ch = curl_init('http://seo.happy-giraffe.com/queries/startThread?secret_key=' . $this->secret_key);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            $result = curl_exec($ch);
//            echo $result;
        }

        echo CJSON::encode(array('status' => true, 'count' => 20));
    }

    public function actionStartThread($secret_key, $se = 3)
    {
        if ($secret_key == $this->secret_key) {
            $parser = new PositionParserThread($se);
            $parser->start();
        }
    }
}
