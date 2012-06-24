<?php
/**
 * Author: alexk984
 * Date: 31.05.12
 */
class QueriesController extends SController
{

    public $secret_key = 'kastgpij35iyiehi';

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

        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser') && !Yii::app()->user->checkAccess('editor'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionAdmin($period = 1)
    {
        $criteria = new CDbCriteria;
        $criteria->with = array('phrases');
        $criteria->together = true;
        $criteria->condition = 'keyword_id IS NOT NULL';
        $criteria->order = 'yandex_week_visits DESC';

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
