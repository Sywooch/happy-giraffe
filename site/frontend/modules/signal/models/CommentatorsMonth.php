<?php

class CommentatorsMonth extends EMongoDocument
{
    const NEW_FRIENDS = 1;
    const PROFILE_VIEWS = 3;
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

    public function primaryKey()
    {
        return 'period';
    }

    public function getMongoDBComponent()
    {
        return Yii::app()->getComponent('mongodb_production');
    }

    /**
     * Возвращает модель для заданного периода, создает если ее нет
     *
     * @static
     * @param string $period
     * @return CommentatorsMonth
     */
    public static function get($period = null)
    {
        if (empty($period))
            $period = date("Y-m");

        $month = self::model()->findByPk($period);
        if ($month === null && $period == date("Y-m")) {
            $month = new CommentatorsMonth;
            $month->period = date("Y-m");
            $month->save();
        }

        return $month;
    }

    /**
     * Расчет рейтинга комментаторов, премий
     */
    public function calculate()
    {
        $commentators = User::model()->findAll('`group`=' . UserGroup::COMMENTATOR);

        $active_commentators = array();
        foreach ($commentators as $commentator) {
            $model = $this->loadCommentator($commentator);
            if ($model !== null) {
                echo 'commentator: ' . $commentator->id . "\n";
                $active_commentators [] = $commentator->id;

                $new_friends = $model->newFriends($this->period);
                $im_messages = $model->imMessages($this->period);
                $profile_view = $this->profileUniqueViews($commentator->id);
                $se_visits = $this->getSeVisits($commentator->id);


                if (isset($this->commentators[(int)$commentator->id])) {
                    $this->commentators[(int)$commentator->id][self::NEW_FRIENDS] = (int)$new_friends;
                    $this->commentators[(int)$commentator->id][self::IM_MESSAGES] = (int)$im_messages;
                    $this->commentators[(int)$commentator->id][self::SE_VISITS] = (int)$se_visits;
                    $this->commentators[(int)$commentator->id][self::PROFILE_VIEWS] = (int)$profile_view;
                } else {
                    $this->commentators[(int)$commentator->id] = array(
                        self::NEW_FRIENDS => (int)$new_friends,
                        self::PROFILE_VIEWS => (int)$profile_view,
                        self::IM_MESSAGES => (int)$im_messages,
                        self::SE_VISITS => (int)$se_visits,
                    );;
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
     * Возвращает модель комментатора по id
     *
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

    /**
     * Вычисляет место в рейтинге занимаемое комментатором
     *
     * @param $user_id
     * @param $counter
     * @return int
     */
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

    /**
     * Вывод места в верстке
     *
     * @param $user_id
     * @param $counter
     * @return string
     */
    public function getPlaceView($user_id, $counter)
    {
        $place = $this->getPlace($user_id, $counter);
        if ($place == 0) {
            return '<span class="place"></span>';
        } elseif ($place < 4)
            return '<span class="place place-' . $place . '">' . $place . ' место</span>';
        return '<span class="place">' . $place . ' место</span>';
    }

    /**
     * Возвращает статистику (кол-во баллов, рейтинг) по показателю
     *
     * @param $user_id
     * @param $counter
     * @return int
     */
    public function getStatValue($user_id, $counter)
    {
        if (!isset($this->commentators[$user_id]))
            return 0;

        foreach ($this->commentators as $_user_id => $data)
            if ($_user_id == $user_id)
                return $data[$counter];
        return 0;
    }

    /**
     * Возвращает все рабочие месяца
     *
     * @return array
     */
    public static function getMonths()
    {
        $result = array();
        $models = CommentatorsMonth::model()->findAll();
        foreach ($models as $model) {
            $result[] = $model->period;
        }

        return array_reverse($result);
    }

    /**
     * Возвращает все рабочие дни всех месяцов
     * @return array
     */
    public static function getDays()
    {
        $result = array();
        $models = CommentatorsMonth::model()->findAll();
        foreach ($models as $model) {
            $result[] = $model->period;
        }

        return array_reverse($result);
    }

    /**
     * Возвращает количество просмотров анкеты
     *
     * @param $user_id
     * @return int
     */
    public function profileUniqueViews($user_id)
    {
        return GApi::model()->uniquePageviews('/user/' . $user_id . '/', $this->period . '-01');
    }

    /**
     * Возвращает количество поисковых заходов на статьи комментатора
     *
     * @param $user_id
     * @return int|mixed
     */
    public function getSeVisits($user_id)
    {
        $models = CommunityContent::model()->findAll('author_id = ' . $user_id);

        $all_count = 0;
        foreach ($models as $model) {
            $url = trim($model->url, '.');
            if (!empty($url)) {
                $visits = SearchEngineVisits::getVisits($url, $this->period);
                $all_count += $visits;
            }
        }

        echo $all_count . "\n";
        return $all_count;
    }
}
