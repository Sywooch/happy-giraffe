<?php
/**
 * Author: alexk984
 * Date: 12.03.12
 */
class ScoreVisits extends EMongoDocument
{
    public $user_id;
    public $last_day;
    public $current_long_days = 0;
    public $days = array();

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'score_visits';
    }

    public function indexes()
    {
        return array(
            'user_id_index' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_DESC,
                ),
                'unique' => true,
            ),
        );
    }

    /**
     * @static
     * @param $user_id
     * @return ScoreVisits
     */
    public static function getModel($user_id)
    {
        $model = ScoreVisits::model()->findByAttributes(array('user_id' => $user_id));
        if ($model === null) {
            $model = new ScoreVisits;
            $model->user_id = $user_id;
        }

        return $model;
    }

    public static function addTodayVisit($user_id)
    {
        $user_id = (int)$user_id;
        $model = self::getModel($user_id);
        $today = date("Y-m-d");
        if (in_array($today, $model->days))
            return ;
        $model->last_day = $today;
        $model->days [] = $today;
        UserScores::addScores($user_id, ScoreAction::ACTION_VISIT);

        if (in_array(date("Y-m-d", strtotime('-1 day')), $model->days)) {
            $model->current_long_days++;
            if ($model->current_long_days == 5){
                UserScores::addScores($user_id, ScoreAction::ACTION_5_DAYS_ATTEND);
            }
            if ($model->current_long_days == 20){
                UserScores::addScores($user_id, ScoreAction::ACTION_20_DAYS_ATTEND);
                $model->current_long_days = 0;
            }
        } else
            $model->current_long_days = 1;

        $model->save();
    }
}
