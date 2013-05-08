<?php

class GApi
{
    protected static $_instance;
    /**
     * @var GoogleAnalytics
     */
    private $ga;

    private function __construct()
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $this->ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $this->ga->setProfile('ga:53688414');
    }

    private function __clone()
    {
    }

    public static function model()
    {
        if (null === self::$_instance)
            self::$_instance = new self();

        return self::$_instance;
    }

    /**
     * Возвращает количество уникальных посещений за период времени
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param bool $include_sub_pages
     * @return int
     */
    public function uniquePageViews($url, $date1, $date2 = null, $include_sub_pages = true)
    {

        return $this->getStat($url, $date1, $date2, $include_sub_pages, 'uniquePageviews');
    }

    /**
     * Возвращает количество посещений за период времени
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param bool $include_sub_pages
     * @return int
     */
    public function pageViews($url, $date1, $date2 = null, $include_sub_pages = true)
    {

        return $this->getStat($url, $date1, $date2, $include_sub_pages, 'pageViews');
    }

    /**
     * Глубина просмотра
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param bool $include_sub_pages
     * @return int
     */
    public function pageDepth($url, $date1, $date2 = null, $include_sub_pages = true)
    {
        return $this->getStat($url, $date1, $date2, $include_sub_pages, 'pageDepth');
    }

    /**
     * Возвращает количество поситителей за период времени
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param bool $include_sub_pages
     * @return int
     */
    public function visitors($url, $date1, $date2 = null, $include_sub_pages = true)
    {
        return $this->getStat($url, $date1, $date2, $include_sub_pages, 'visitors');
    }

    /**
     * Возвращает количество посещений за период времени
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param bool $include_sub_pages
     * @return int
     */
    public function visits($url, $date1, $date2 = null, $include_sub_pages = true)
    {
        return $this->getStat($url, $date1, $date2, $include_sub_pages, 'visits');
    }

    /**
     * Возвращает количество заходов из поисковиков за период времени
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param bool $include_sub_pages
     * @return int
     */
    public function organicSearches($url, $date1, $date2 = null, $include_sub_pages = true)
    {
        return $this->getStat($url, $date1, $date2, $include_sub_pages, 'organicSearches');
    }

    /**
     * Возвращает значение параметра за период
     *
     * @param $url
     * @param $date1
     * @param $date2
     * @param $include_sub_pages
     * @param $stat
     * @return int
     */
    private function getStat($url, $date1, $date2, $include_sub_pages, $stat)
    {
        if (empty($date2))
            $date2 = $this->getLastPeriodDay($date1);
        $this->ga->setDateRange($date1, $date2);

        if ($include_sub_pages)
            $filter = urlencode('ga:pagePath=~' . $url . '*');
        else
            $filter = urlencode('ga:pagePath==' . $url);

        try {
            sleep(1);
            $report = $this->ga->getReport(array(
                'metrics' => urlencode('ga:'.$stat),
                'filters' => $filter,
            ));

        } catch (Exception $err) {
            echo $err->getMessage();
            sleep(60);
            return $this->getStat($url, $date1, $date2, $include_sub_pages, $stat);
        }

        return isset($report[""]['ga:'.$stat]) ? $report[""]['ga:'.$stat] : 0;
    }

    /**
     * Вычисляет последний день месяца
     *
     * @param $date
     * @return string
     */
    public function getLastPeriodDay($date)
    {
        return date('Y', strtotime($date)).'-'.date('m', strtotime($date)).'-'.
            str_pad(cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($date)), date('Y', strtotime($date))), 2, "0", STR_PAD_LEFT);
    }
}