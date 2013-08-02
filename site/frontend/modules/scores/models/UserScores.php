<?php

/**
 * This is the model class for table "score__user_scores".
 *
 * The followings are the available columns in table 'score__user_scores':
 * @property integer $user_id
 * @property integer $scores
 * @property integer $seen_scores
 * @property integer $level_id
 *
 * The followings are the available model relations:
 * @property User $user
 */
class UserScores extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserScores the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'score__user_scores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id', 'required'),
            array('user_id, scores, seen_scores, level_id', 'numerical', 'integerOnly' => true),
            array('user_id, scores, level_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public static function getModel($user_id)
    {
        $model = UserScores::model()->findByPk($user_id);
        if ($model === null) {
            if (User::model()->findByPk($user_id) === null)
                return null;

            $model = new UserScores;
            $model->scores = 0;
            $model->user_id = $user_id;
        }

        return $model;
    }

    /**
     * возвращает достижения пользователя в виде нужном для вывода
     *
     * @return ScoreAchievement[]
     */
    public function getActualAchieves()
    {
        return ScoreAchievement::model()->findAllByPk($this->getActualAchievesIds());
    }

    /**
     * возвращает массив id достижений пользователя
     *
     * @return array
     */
    public function getActualAchievesIds()
    {
        $value = Yii::app()->cache->get('achieve_list_' . $this->user_id);
        if ($value === false) {
            $achieves = ScoreAchievement::model()->roots();
            $userAchieves = $this->user->achievements;
            $value = array();

            foreach ($achieves as $achieve) {
                $current_achieve = $achieve;
                foreach ($userAchieves as $userAchieve) {
                    if ($current_achieve->id == $userAchieve->id)
                        $current_achieve = $current_achieve->next;
                }

                $value[] = $current_achieve->id;
            }

            $dependency = new CDbCacheDependency('SELECT count(achievement_id) FROM score__user_achievements WHERE user_id=' . $this->user_id);
            Yii::app()->cache->set('achieve_list_' . $this->user_id, $value, 0, $dependency);
        }

        return $value;
    }

    /**
     * Возвращает объединенный массив трофеев и достижений пользователя, сортировка по дате получения
     * @param int $user_id
     * @param int $limit
     * @return ScoreUserAchievement|ScoreUserAward
     */
    public function getAwardsWithAchievements($user_id, $limit = null)
    {
        $awards = ScoreUserAward::getUserAwards($user_id);
        $achievements = ScoreUserAchievement::getUserAchievements($user_id);
        $all = array_merge($awards, $achievements);
        usort($all, array($this, 'cmpCreated'));
        if (empty($limit))
            return $all;
        else
            return array_slice($all, 0, $limit);
    }

    private function cmpCreated($a, $b)
    {
        if (strtotime($a->created) == strtotime($b->created))
            return ($a->id < $b->id) ? +1 : -1;
        return (strtotime($a->created) < strtotime($b->created)) ? +1 : -1;
    }

    /**
     * Возвращает следующую и предыдущую награду
     * @param int $user_id
     * @param ScoreUserAchievement|ScoreUserAward $some_award
     * @return ScoreUserAchievement[]|ScoreUserAward[]
     */
    public static function getNextPrev($user_id, $some_award)
    {
        $awards = self::model()->getAwardsWithAchievements($user_id);
        foreach($awards as $key => $award){
            if ($award->id == $award->id && get_class($award) == get_class($some_award)){
                $prev = isset($awards[$key - 1])?$awards[$key - 1]:null;
                $next = isset($awards[$key + 1])?$awards[$key + 1]:null;
                return array($next, $prev);
            }
        }
        return array(null, null);
    }
}