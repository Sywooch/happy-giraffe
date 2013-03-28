<?php

Yii::import('site.frontend.helpers.*');

class DefaultController extends SController
{
    public $layout = '//layouts/traffic';
    public $pageTitle = 'ТРАФИК';

    public function actionIndex($date = null, $last_date = null, $parent_id = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null) {
            $date = date("Y-m-d", strtotime('-6 days'));
            $days = 7;
        } else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);

        $sections = empty($parent_id)
            ? TrafficSection::model()->findAll('parent_id IS NULL') :
            TrafficSection::model()->findAll('parent_id = :parent_id', array(':parent_id' => $parent_id));

        $all_section = empty($parent_id) ? TrafficSection::model()->findByPk(1) : TrafficSection::model()->findByPk($parent_id);

        $this->render('index', compact('last_date', 'date', 'period', 'parent_id', 'sections', 'all_section'));
    }

    /*public function actionTest()
    {
        for ($i = 1; $i < 36; $i++) {
            $model = new TrafficSection();
            $model->url = 'community/'.$i;
            $model->title = Community::model()->findByPk($i)->title;
            $model->save();
        }
    }*/

    public function actionSection($id){
        $section = $this->loadModel($id);

        $last_date = date("Y-m-d");
        $date = date("Y-m-d", strtotime('-30 days'));
        $period = $this->getPeriod($last_date, 30);

        $this->render('section', compact('section', 'last_date', 'date', 'period'));
    }

    public function getPeriod($date, $days)
    {
        if ($date != date("Y-m-d")) {
            if ($date == date("Y-m-d", strtotime('-1 day')) && $days == 1)
                return 'yesterday';
            return 'manual';
        }
        if ($days == 1)
            return 'today';
        if ($days == 7)
            return 'week';
        if ($days >= 29 && $days <= 32)
            return 'month';

        return 'manual';
    }

    /**
     * @param int $id model id
     * @return TrafficSection
     * @throws CHttpException
     */
    public function loadModel($id){
        $model = TrafficSection::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}