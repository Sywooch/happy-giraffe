<?php

class DefaultController extends LiteController
{

    public $social_title;
    public $zodiac = false;
    public $date = false;
    public $period = false;
    public $alias = false;

    public function getUrl($params)
    {
        $defaultParams = array(
            'zodiac' => $this->zodiac,
            'date' => $this->date,
            'period' => $this->period,
            'alias' => $this->alias,
        );
        // Если перебивается дата, то сбрасываем алиас
        if (isset($params['date']))
        {
            $params['alias'] = false;
        }
        // Если перебивается алиас, то скидываем дату и период
        if (isset($params['alias']) && $params['alias'])
        {
            $params['date'] = false;
            $params['period'] = isset($params['period']) ? $params['period'] : 'day';
        }
        $params = CMap::mergeArray($defaultParams, $params);
        return Yii::app()->createUrl($this->route, $params);
    }

    public function beforeAction($action)
    {
        $this->zodiac = Yii::app()->request->getQuery('zodiac', false);
        $this->period = Yii::app()->request->getQuery('period', false);
        $this->date = Yii::app()->request->getQuery('date', false);
        $this->alias = Yii::app()->request->getQuery('alias', false);

        if ($this->alias === 'yesterday')
            throw new CHttpException(404);

        $package = Yii::app()->user->isGuest ? 'lite_horoscope' : 'lite_horoscope_user';
        Yii::app()->clientScript->registerPackage($package);
        Yii::app()->clientScript->useAMD = true;

        return parent::beforeAction($action);
    }

    /**
     * @sitemap dataSource=sitemapList
     */
    public function actionList($zodiac, $period, $date, $alias)
    {
        $this->render('list');
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($zodiac, $period, $date, $alias)
    {
        $zodiac = Horoscope::model()->getZodiacId($this->zodiac);
        $model = null;
        switch ($this->period)
        {
            case 'day':
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'date' => date("Y-m-d", $date)));
                break;
            case 'month':
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y', $date), 'month' => date('n', $date)));
                break;
            case 'year':
                $model = Horoscope::model()->findByAttributes(array('zodiac' => $zodiac, 'year' => date('Y', $date), 'month' => null));
                break;
        }
        if (!$model)
            throw new CHttpException(404);

        $this->render('view', array('model' => $model));
    }

    public function sitemapView()
    {
        Yii::import('application.modules.services.modules.horoscope.models.Horoscope');
        $result = array();

        // на сегодня
        foreach (Horoscope::model()->zodiac_list_eng as $z) {
            $result[] = array(
                'params' => array(
                    'zodiac' => $z,
                    'period' => 'day',
                    'date' => time(),
                    'alias' => 'today',
                ),
                'changefreq' => 'daily',
                'priority' => 1,
            );
        }

        // на завтра
        foreach (Horoscope::model()->zodiac_list_eng as $z) {
            $result[] = array(
                'params' => array(
                    'zodiac' => $z,
                    'period' => 'day',
                    'date' => strtotime('+1 day'),
                    'alias' => 'tomorrow',
                ),
                'changefreq' => 'daily',
                'priority' => 1,
            );
        }

        // на текущий месяц
        foreach (Horoscope::model()->zodiac_list_eng as $z) {
            $result[] = array(
                'params' => array(
                    'zodiac' => $z,
                    'period' => 'month',
                    'date' => time(),
                    'alias' => 'today',
                ),
                'changefreq' => 'weekly',
                'priority' => 1,
            );
        }

        // на текущий год
        foreach (Horoscope::model()->zodiac_list_eng as $z) {
            $result[] = array(
                'params' => array(
                    'zodiac' => $z,
                    'period' => 'year',
                    'date' => time(),
                    'alias' => 'today',
                ),
                'changefreq' => 'monthly',
                'priority' => 1,
            );
        }

        $data = Yii::app()->db->createCommand()
            ->select('*')
            ->from(Horoscope::model()->tableName())
            ->queryAll();

        foreach ($data as $row) {
            // на произвольный месяц
            if (! empty($row['year']) && ! empty($row['month'])) {
                if (strtotime('-2 month') > mktime(0, 0, 0, $row['month'], 1, $row['year'])) {
                    $changefreq = 'monthly';
                    $priority = 0.5;
                } else {
                    $changefreq = 'daily';
                    $priority = 1;
                }

                $result[] = array(
                    'params' => array(
                        'zodiac' => Horoscope::model()->zodiac_list_eng[$row['zodiac']],
                        'period' => 'month',
                        'date' => mktime(0, 0, 0, $row['month'], 1, $row['year']),
                        'alias' => false,
                    ),
                    'changefreq' => $changefreq,
                    'priority' => $priority,
                );
            // на произвольную дату
            } elseif (empty($row['year']) && empty($row['month'])) {
                if (strtotime('-1 month') > strtotime($row['date'])) {
                    $changefreq = 'monthly';
                    $priority = 0.5;
                } else {
                    $changefreq = 'daily';
                    $priority = 1;
                }

                $result[] = array(
                    'params' => array(
                        'zodiac' => Horoscope::model()->zodiac_list_eng[$row['zodiac']],
                        'period' => 'day',
                        'date' => strtotime($row['date']),
                        'alias' => false,
                    ),
                    'changefreq' => $changefreq,
                    'priority' => $priority,
                );
            }
        }

        return $result;
    }

    public function sitemapList()
    {
        Yii::import('application.modules.services.modules.horoscope.models.Horoscope');
        $result = array();

        // на сегодня
        $result[] = array(
            'params' => array(
                'zodiac' => false,
                'period' => 'day',
                'date' => time(),
                'alias' => 'today',
            ),
            'changefreq' => 'daily',
            'priority' => 0.9,
        );

        // на завтра
        $result[] = array(
            'params' => array(
                'zodiac' => false,
                'period' => 'day',
                'date' => strtotime('+1 day'),
                'alias' => 'tomorrow',
            ),
            'changefreq' => 'daily',
            'priority' => 0.9,
        );

        // на месяц
        $result[] = array(
            'params' => array(
                'zodiac' => false,
                'period' => 'month',
                'date' => time(),
                'alias' => 'today',
            ),
            'changefreq' => 'weekly',
            'priority' => 0.9,
        );

        // на год
        $result[] = array(
            'params' => array(
                'zodiac' => false,
                'period' => 'year',
                'date' => time(),
                'alias' => 'today',
            ),
            'changefreq' => 'monthly',
            'priority' => 0.9,
        );

        return $result;
    }
}