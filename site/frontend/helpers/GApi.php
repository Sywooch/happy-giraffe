<?php

class GApi {
    public static function getViewsByPath($path, $startDate = null, $endDate = null)
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('nikita@happy-giraffe.ru', 'V$6e}Ru6=2AkfUk');
        $ga->setProfile('ga:53688414');
        $ga->setDateRange($startDate === null ? '2005-01-01' : $startDate, $endDate === null ? date('Y-m-d') : $endDate);

        $array = $ga->getReport(
            array(
                'metrics' => urlencode('ga:uniquePageviews'),
                'filters' => urlencode('ga:pagePath=~' . $path),
            )
        );

        return ($array) ? $array['']['ga:uniquePageviews'] : 0;
    }
}