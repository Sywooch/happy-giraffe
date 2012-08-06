<?php

class DefaultController extends HController
{

    /**
     * @sitemap dataSource=getSitemapUrls
     */
	public function actionIndex($calendar, $slug = null)
	{
        $criteria = new CDbCriteria;
        $criteria->with = array('contents', 'contents.commentsCount', 'communities', 'services');
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

    public function getSitemapUrls()
    {
        $data = array(
            array(
                'params' => array(
                    'calendar' => 0,
                ),
            ),
            array(
                'params' => array(
                    'calendar' => 1,
                ),
            ),
        );

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
                'priority' => 0.5,
                'changefreq' => 'daily',
            );
        }
        return $data;
    }
}