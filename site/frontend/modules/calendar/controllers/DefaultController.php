<?php

class DefaultController extends HController
{

    /**
     * @sitemap dataSource=sitemapIndex
     */
	public function actionIndex($calendar, $slug = null)
	{
        $criteria = new CDbCriteria;
        $criteria->with = array('contents', 'contents.commentsCount', 'services');
        if ($slug === null) {
            $criteria->order = 't.id';
            $criteria->compare('calendar', $calendar);
        } else {
            $criteria->compare('calendar', $calendar);
            $criteria->compare('t.slug', $slug);
        }
        $period = CalendarPeriod::model()->find($criteria);
        if ($period === null)
            throw new CHttpException(404);

        if ($slug === null)
            Yii::app()->clientScript->registerLinkTag('canonical', null, $period->getUrl(true));

        $periods = CalendarPeriod::model()->findAllByAttributes(array('calendar' => $calendar));
        $calendarTitle = ($calendar == 0) ? 'Календарь развития ребёнка' : 'Календарь беременности';
        $this->pageTitle = $calendarTitle . ' - ' . $period->title;
        $this->render('index', compact('period', 'periods'));
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
}