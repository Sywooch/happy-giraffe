<?php

Yii::import('site.frontend.helpers.*');

class DefaultController extends SController
{
    public $layout = '//layouts/traffic';
    public $pageTitle = 'ТРАФИК';

    public function actionIndex($date = null, $last_date = null)
    {
        if ($last_date == null)
            $last_date = date("Y-m-d");
        if ($date == null) {
            $date = date("Y-m-d");
            $days = 1;
        } else
            $days = round((strtotime($last_date) - strtotime($date)) / 86400) + 1;

        $period = $this->getPeriod($last_date, $days);

        $this->render('index', compact('last_date', 'date', 'period'));
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
}