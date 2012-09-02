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
        var_dump($month);
        if ($month === null && $period == date("Y-m")) {
            $month = new CommentatorsMonthStats;
            $month->period = date("Y-m");
            $month->calculate();
            if (!$month->save())
                var_dump($month->getErrors());
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

    public function calculate($cache = true)
    {
        $commentators = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);
        $this->commentators = array();

        foreach ($commentators as $commentator) {
            $model = $this->loadCommentator($commentator);
            if ($model !== null) {
                $result = array(
                    self::NEW_FRIENDS => (int)$model->newFriends($this->period),
                    self::BLOG_VISITS => (int)$model->blogVisits($this->period,$cache),
                    self::PROFILE_UNIQUE_VIEWS => (int)$model->profileUniqueViews($this->period, $cache),
                    self::IM_MESSAGES => (int)$model->imMessages($this->period),
                    self::SE_VISITS => (int)$model->seVisits($this->period, $cache),
                );
                $this->commentators[(int)$commentator->id] = $result;
            }
        }
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

        asort($arr);
        $i = 1;
        foreach ($arr as $_user_id => $data) {
            if ($_user_id == $user_id || $data == $arr[$user_id])
                return $i;
            $i++;
        }

        return null;
    }

    public function getPlaceView($user_id, $counter)
    {
        $place = $this->getPlace($user_id, $counter);
        if ($place < 4)
            return '<span class="place place-' . $place . '">' . $place . ' место</span>';
        return '<span class="place">' . $place . ' место</span>';
    }

    public function getStatValue($user_id, $counter)
    {
        foreach ($this->commentators as $_user_id => $data)
            if ($_user_id == $user_id )
                return $data[$counter];
        return  0;
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
}
