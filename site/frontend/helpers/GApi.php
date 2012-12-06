<?php

class GApi
{
    public static function getViewsByPath($path, $startDate = null, $endDate = null)
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');

        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
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

    public static function getUrlOrganicSearches($ga, $date1, $date2, $url, $include_sub_pages = true)
    {
        $ga->setDateRange($date1, $date2);

        if ($include_sub_pages)
            $filter = urlencode('ga:pagePath=~' . $url . '*');
        else
            $filter = urlencode('ga:pagePath==' . $url);

        try {
            sleep(1);
            $report = $ga->getReport(array(
                'metrics' => urlencode('ga:organicSearches'),
                'filters' => $filter,
            ));

        } catch (Exception $err) {
            echo $err->getMessage();
            sleep(60);
            return self::getUrlOrganicSearches($ga, $date1, $date2, $url, $include_sub_pages);
        }

        if (isset($report[""]['ga:organicSearches']))
            return $report[""]['ga:organicSearches'];
        return 0;
    }
}