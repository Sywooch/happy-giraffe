<?php

class DefaultController extends LiteController
{

    const CHILD = 0;
    const PREGNACY = 1;

    public $calendar = false;

    public function beforeAction($action)
    {
        
        //Yii::app()->clientScript->useAMD = true;
        //Yii::app()->clientScript->registerLitePackage('calendar');


        $package = Yii::app()->user->isGuest ? 'lite_calendar' : 'lite_calendar_user';
        Yii::app()->clientScript->registerPackage($package);
        Yii::app()->clientScript->useAMD = true;
        
        return parent::beforeAction($action);
    }

        /**
     * @sitemap dataSource=sitemapIndex
     */
    public function actionIndex($calendar, $slug = null)
    {
        $this->calendar = $calendar;
        $periods = CalendarPeriod::model()->findAllByAttributes(array('calendar' => $calendar));
        if ($slug === null)
        {
            $this->render('index_v2', compact('periods'));
        }
        else
        {
            $criteria = new CDbCriteria;
            $criteria->with = array('contents', 'contents.commentsCount', 'services');
            $criteria->compare('calendar', $calendar);
            $criteria->compare('t.slug', $slug);
            $period = CalendarPeriod::model()->find($criteria);
            if ($period === null)
                throw new CHttpException(404);

            $this->render('view_v2', compact('period', 'periods'));
        }
    }

    public function sitemapIndex()
    {
        $data = array();

        $models = Yii::app()->db->createCommand()
            ->select('calendar, slug')
            ->from('calendar__periods')
            ->queryAll();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'calendar' => $model['calendar'],
                    'slug' => $model['slug'],
                ),
            );
        }

        return $data;
    }

    public function actionJoin()
    {
        $this->layout = 'join';
        if (!Yii::app()->user->isGuest)
            $this->redirect('/');
        $this->render('join');
    }

    public function getTexts()
    {
        return array(
            'menu' => array('_menu_child', '_menu_pregnacy'),
            'title' => array('Календарь развития ребёнка', 'Календарь беременности'),
            'class' => array('child', 'pregnancy'),
        );
    }

    public function getText($type, $default = false)
    {
        return isset($this->texts[$type][$this->calendar]) ? $this->texts[$type][$this->calendar] : $default;
    }

}