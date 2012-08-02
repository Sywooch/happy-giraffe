<?php

class DefaultController extends HController
{
	public function actionIndex($calendar, $slug = null)
	{
        $criteria = new CDbCriteria;
        $criteria->with = array('contents', 'contents.commentsCount', 'communities', 'services');
        if ($slug === null) {
            $criteria->order = 't.id';
            $criteria->compare('calendar', $calendar);
        } else {
            $criteria->compare('t.slug', $slug);
        }
        $period = CalendarPeriod::model()->find($criteria);
        if ($period === null)
            throw new CHttpException(404);

        $periods = CalendarPeriod::model()->findAllByAttributes(array('calendar' => $calendar));
	    $this->render('index', compact('period', 'periods'));
	}
}