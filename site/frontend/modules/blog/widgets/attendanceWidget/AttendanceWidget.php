<?php

class AttendanceWidget extends CWidget {

    public $user;

    public function run()
    {
        if (is_int($this->user))
            $this->user = User::model()->findByPk($this->user);

        $visitorsToday = Yii::app()->piwik->getUniqueVisitors('day', 'today', 'pageUrl=@' . $this->getBlogUrl());
        $viewsToday = Yii::app()->piwik->getPageViews('day', 'today', 'pageUrl=@' . $this->getBlogUrl());
        $visitorsTotal = Yii::app()->piwik->getUniqueVisitors('range', '2013-01-01,today', 'pageUrl=@' . $this->getBlogUrl());

        $this->render('index', compact('visitorsToday', 'viewsToday', 'visitorsTotal'));
    }

    protected function getBlogUrl()
    {
        return $this->user->blogUrl;
    }
}