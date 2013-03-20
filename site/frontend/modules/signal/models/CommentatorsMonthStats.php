<?php

class CommentatorsMonthStats extends EMongoDocument
{
    const NEW_FRIENDS = 1;
    const PROFILE_VIEWS = 3;
    const IM_MESSAGES = 4;
    const SE_VISITS = 5;

    public $period;
    public $commentators = array();
    public $workingDays = array();
    public $working_days_count = 22;

    /**
     * @var GoogleAnalytics
     */
    private $ga;

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
        Yii::import('site.frontend.extensions.GoogleAnalytics');
        $this->loginGa();

        $commentators = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);
        //$this->commentators = array();

        $active_commentators = array();
        foreach ($commentators as $commentator) {
            $model = $this->loadCommentator($commentator);
            if ($model !== null) {
                echo 'commentator: ' . $commentator->id . "\n";
                $active_commentators [] = $commentator->id;

                $new_friends = $model->newFriends($this->period);
                $im_messages = $model->imMessages($this->period);
                $blog_visits = $this->blogVisits($commentator->id);
                $profile_view = $this->profileUniqueViews($commentator->id);
                $se_visits = $this->getSeVisits($commentator->id);


                if (isset($this->commentators[(int)$commentator->id])) {
                    $this->commentators[(int)$commentator->id][self::NEW_FRIENDS] = (int)$new_friends;
                    $this->commentators[(int)$commentator->id][self::IM_MESSAGES] = (int)$im_messages;
                    if ($se_visits !== null)
                        $this->commentators[(int)$commentator->id][self::SE_VISITS] = (int)$se_visits;

                    if ($blog_visits !== null)
                        $this->commentators[(int)$commentator->id][self::BLOG_VISITS] = (int)$blog_visits;
                    if ($profile_view !== null)
                        $this->commentators[(int)$commentator->id][self::PROFILE_VIEWS] = (int)$profile_view;
                } else {

                    $result = array(
                        self::NEW_FRIENDS => (int)$new_friends,
                        self::BLOG_VISITS => (int)$blog_visits,
                        self::PROFILE_VIEWS => (int)$profile_view,
                        self::IM_MESSAGES => (int)$im_messages,
                        self::SE_VISITS => (int)$se_visits,
                    );
                    $this->commentators[(int)$commentator->id] = $result;
                }
                $this->save();
            }
        }

        //remove deleted commentators
        foreach ($this->commentators as $commentator_id => $val)
            if (!in_array($commentator_id, $active_commentators))
                unset($this->commentators[$commentator_id]);

        $this->save();
    }

    /**
     * @param User $commentator
     * @return CommentatorWork
     */
    public function loadCommentator($commentator)
    {
        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$commentator->id);
        $model = CommentatorWork::model()->find($criteria);
        if ($model === null || $model->isNotWorkingAlready())
            return null;

        return $model;
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
        return GApi::model()->uniquePageviews('/user/' . $user_id . '/', $this->period . '-01', $this->period . '-' . $this->getLastPeriodDay($this->period));
    }

    public function blogVisits($user_id)
    {
        return GApi::model()->visitors('/user/' . $user_id . '/blog/', $this->period . '-01', $this->period . '-' . $this->getLastPeriodDay($this->period));
    }

    public function getSeVisits($user_id)
    {
        $models = CommunityContent::model()->findAll('author_id = ' . $user_id);

        $all_count = 0;
        foreach ($models as $model) {
            $url = trim($model->url, '.');
            if (!empty($url)) {
                $visits = $this->getVisits($url);
                //echo $url . ' - ' . $visits . "\n";
                $all_count += $visits;

                if ($visits !== null)
                    $this->addPageVisit($url, $visits);
                else
                    $all_count += $this->getPageVisitsCount($url);
            }
        }

        echo $all_count . "\n";
        return $all_count;
    }

    public function getVisits($url)
    {
        return SearchEngineVisits::getVisits($url, $this->period);
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

    public function loginGa()
    {
        $this->ga = new GoogleAnalytics('alexk984@gmail.com', Yii::app()->params['gaPass']);
        $this->ga->setProfile('ga:53688414');
    }
}
