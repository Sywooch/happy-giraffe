<?php

class CommentatorsMonthStats extends EMongoDocument
{
    const NEW_FRIENDS = 1;
    const BLOG_VISITS = 2;
    const PROFILE_UNIQUE_VIEWS = 3;
    const IM_MESSAGES = 4;
    const SE_VISITS = 5;

    public $period;
    public $commentators = array();
    public $workingDays = array();
    public $working_days_count = 22;
    public $page_visits = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'commentators_month_stats';
    }

    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_production');
    }

    /**
     * @static
     * @param string $period
     * @return CommentatorsMonthStats
     */
    public static function getOrCreateWorkingMonth($period = null)
    {
        if (empty($period))
            $period = date("Y-m");

        $month = CommentatorsMonthStats::getWorkingMonth($period);
        if ($month === null && $period == date("Y-m")) {
            $month = new CommentatorsMonthStats;
            $month->period = date("Y-m");
            $month->calculate();
            $month->save();
        }

        return $month;
    }

    /**
     * @static
     * @param string $period
     * @return CommentatorsMonthStats
     */
    public static function getWorkingMonth($period)
    {
        return CommentatorsMonthStats::model()->find(new EMongoCriteria(array(
            'conditions' => array(
                'period' => array('==' => $period)
            ),
        )));
    }

    public function calculate()
    {
        $commentators = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);
        $this->commentators = array();

        foreach ($commentators as $commentator) {
            $model = $this->loadCommentator($commentator);
            if ($model !== null) {

                echo 'user: ' . $commentator->id . "\n";

                $result = array(
                    self::NEW_FRIENDS => (int)$model->newFriends($this->period),
                    self::BLOG_VISITS => (int)$this->blogVisits($commentator->id),
                    self::PROFILE_UNIQUE_VIEWS => (int)$this->profileUniqueViews($commentator->id),
                    self::IM_MESSAGES => (int)$model->imMessages($this->period),
                    self::SE_VISITS => (int)$this->getSeVisits($commentator->id),
                );
                $this->commentators[(int)$commentator->id] = $result;
            }
        }

        $this->save();
    }

    /**
     * @param $commentator
     * @return CommentatorWork
     */
    public function loadCommentator($commentator)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$commentator->id);
        return CommentatorWork::model()->find($criteria);
    }

    public function getPlace($user_id, $counter)
    {
        if (!isset($this->commentators[$user_id]))
            return 0;

        $arr = array();
        foreach ($this->commentators as $_user_id => $data)
            $arr[$_user_id] = $data[$counter];

        arsort($arr);
        $i = 1;
        foreach ($arr as $_user_id => $data) {
            if ($_user_id == $user_id || $data == $arr[$user_id]) {
                if ($data == 0)
                    return 0;
                return $i;
            }
            $i++;
        }

        return 0;
    }

    public function getPlaceView($user_id, $counter)
    {
        $place = $this->getPlace($user_id, $counter);
        if ($place == 0) {
            return '<span class="place"></span>';
        } elseif ($place < 4)
            return '<span class="place place-' . $place . '">' . $place . ' место</span>';
        return '<span class="place">' . $place . ' место</span>';
    }

    public function getStatValue($user_id, $counter)
    {
        if (!isset($this->commentators[$user_id]))
            return 0;

        foreach ($this->commentators as $_user_id => $data)
            if ($_user_id == $user_id)
                return $data[$counter];
        return 0;
    }

    public static function getMonths()
    {
        $result = array();
        $models = CommentatorsMonthStats::model()->findAll();
        foreach ($models as $model) {
            $result[] = $model->period;
        }

        return array_reverse($result);
    }

    public static function getDays()
    {
        $result = array();
        $models = CommentatorsMonthStats::model()->findAll();
        foreach ($models as $model) {
            $result[] = $model->period;
        }

        return array_reverse($result);
    }

    public function profileUniqueViews($user_id)
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');
        $ga->setDateRange($this->period . '-01', $this->period . '-' . $this->getLastPeriodDay($this->period));
        try {
            $report = $ga->getReport(array(
                'metrics' => urlencode('ga:uniquePageviews'),
                'filters' => urlencode('ga:pagePath==' . '/user/' . $user_id . '/'),
            ));
        } catch (Exception $err) {

            return 0;
        }

        if (!empty($report))
            $value = $report['']['ga:uniquePageviews'];
        else
            $value = 0;

        return $value;
    }

    public function blogVisits($user_id)
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');
        $ga->setDateRange($this->period . '-01', $this->period . '-' . $this->getLastPeriodDay($this->period));
        try {
            $report = $ga->getReport(array(
                'metrics' => urlencode('ga:visitors'),
                'filters' => urlencode('ga:pagePath=~' . '/user/' . $user_id . '/blog/*'),
            ));
        } catch (Exception $err) {
            return 0;
        }

        if (!empty($report))
            $value = $report['']['ga:visitors'];
        else
            $value = 0;

        return $value;
    }

    public function getSeVisits($user_id)
    {
        $models = CommunityContent::model()->findAll('author_id = ' . $user_id);

        $all_count = 0;
        foreach ($models as $model) {
            $url = trim($model->url, '.');
            $visits = $this->getVisits($url);
            echo $url . ' - ' . $visits . "\n";
            $all_count += $visits;

            $this->addPageVisit($url, $visits);
        }

        echo $all_count . "\n";
        return $all_count;
    }

    public function getVisits($url)
    {
        Yii::import('site.frontend.extensions.GoogleAnalytics');

        $period = date("Y-m");
        $ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $ga->setProfile('ga:53688414');
        $ga->setDateRange($period . '-01', $period . '-' . $this->getLastPeriodDay($period));

        $report = $ga->getReport(array(
            'metrics' => urlencode('ga:organicSearches'),
            'filters' => urlencode('ga:pagePath==' . $url),
        ));

        sleep(1);
        if (isset($report[""]['ga:organicSearches']))
            return $report[""]['ga:organicSearches'];
        return 0;
    }

    public function addPageVisit($url, $value)
    {
        $this->page_visits[$url] = $value;
    }

    public function getPageVisitsCount($url)
    {
        if (isset($this->page_visits[$url]))
            return $this->page_visits[$url];
        return 0;
    }

    public function getLastPeriodDay($period)
    {
        return str_pad(cal_days_in_month(CAL_GREGORIAN, date('n', strtotime($period)), date('Y', strtotime($period))), 2, "0", STR_PAD_LEFT);
    }
}
