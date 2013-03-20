<?php

class AttendanceWidget extends CWidget {

    public $user_id;

    public function run()
    {
        $path = '/user/' . $this->user_id . '/blog/*';

        $total = Yii::app()->cache->get($this->getCacheId('total'));
        if ($total === false) {
            $total = GApi::uniquePageViews($path);
            Yii::app()->cache->set($this->getCacheId('total'), $total, 600);
        }

        $yesterday = Yii::app()->cache->get($this->getCacheId('yesterday'));
        if ($yesterday === false) {
            $yesterdayDate = date('Y-m-d', time() - 60 * 60 * 24);
            $yesterday = GApi::uniquePageViews($path, $yesterdayDate, $yesterdayDate);
            Yii::app()->cache->set($this->getCacheId('yesterday'), $yesterday, 0, new CExpressionDependency(), date('Y-m-d'));
        }

        $today = Yii::app()->cache->get($this->getCacheId('today'));
        if ($today === false) {
            $todayDate = date('Y-m-d');
            $today = GApi::uniquePageViews($path, $todayDate, $todayDate);
            Yii::app()->cache->set($this->getCacheId('today'), $today, 600);
        }

        $this->render('index', compact('total', 'yesterday', 'today'));
    }

    protected function getCacheId($key)
    {
        return 'BlogStats_' . $this->user_id . '_' . $key;
    }
}