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

        if (!Yii::app()->user->checkAccess('admin') && !Yii::app()->user->checkAccess('superuser')
            && !Yii::app()->user->checkAccess('editor') && !Yii::app()->user->checkAccess('promotion')
        )
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        $this->render('index');
    }

    public function actionAdmin($period = 1, $sort = 'yandex_visits', $mode = null)
    {
        $criteria = new CDbCriteria;

        if (!empty($mode)){
            $criteria->with = array('phrases', 'phrases.keyword', 'phrases.lastPosition');
            $criteria->together = true;
        }
        else
            $criteria->with = array('phrases', 'phrases.keyword');

        if ($period == 2)
            $criteria->condition = '(yandex_month_visits != 0 OR google_month_visits != 0)';
        else
            $criteria->condition = '(yandex_week_visits != 0 OR google_week_visits != 0)';

        if ($mode == 1)
            $criteria->condition.= ' AND wordstat >= 10000 AND `lastPosition`.`position` > 20 AND `lastPosition`.`position` < 1000 ';
        elseif ($mode == 2)
            $criteria->condition.= ' AND wordstat >= 10000 AND `lastPosition`.`position` > 10 AND `lastPosition`.`position` <= 20';
        elseif ($mode == 3)
            $criteria->condition.= ' AND wordstat > 1500 AND wordstat < 10000 AND `lastPosition`.`position` > 20 AND `lastPosition`.`position` < 1000 ';
        elseif ($mode == 4)
            $criteria->condition.= ' AND wordstat > 1500 AND wordstat < 10000 AND `lastPosition`.`position` > 10 AND `lastPosition`.`position` <= 20 ';


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
        if (!empty($mode))
            $pages->setPageSize(2000);
        else
            $pages->setPageSize(20);
        $pages->applyLimit($criteria);

        $models = Page::model()->findAll($criteria);
        $this->render('admin', compact('models', 'pages', 'period', 'mode'));
    }

    public function actionParse()
    {
        if (!Yii::app()->user->checkAccess('admin'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $metrica = new YandexMetrica();
        $metrica->parseQueries();
        $metrica->convertToSearchPhraseVisits();

        $response = array(
            'status' => true,
            'count' => Query::model()->count()
        );

        echo CJSON::encode($response);
    }

    public function getDates($period)
    {
        $week_day = date('N');
        if ($period == 1) {
            $i = 1;
        } else {
            $i = 4;

        }
        $time1 = strtotime('-' . (7 * $i + $week_day - 1) . ' days', time());
        $time2 = strtotime('-' . ($week_day) . ' days', time());
        return Yii::app()->dateFormatter->format('d MMMM', $time1) . ' - '
            . Yii::app()->dateFormatter->format('d MMMM', $time2);
    }
}
