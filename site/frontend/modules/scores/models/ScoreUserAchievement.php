<?php

/**
 * This is the model class for table "score__user_achievements".
 *
 * The followings are the available columns in table 'score__user_achievements':
 * @property string $id
 * @property string $user_id
 * @property string $achievement_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property ScoreAchievement $achievement
 * @property User $user
 */
class ScoreUserAchievement extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreUserAchievement the static model class
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
        return 'score__user_achievements';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, achievement_id', 'required'),
            array('user_id, achievement_id', 'length', 'max' => 10),
            array('created', 'safe'),
            array('id, user_id, achievement_id, created', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'achievement' => array(self::BELONGS_TO, 'ScoreAchievement', 'achievement_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function behaviors()
    {
        return array(
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => null,
            ),
        );
    }

    public function afterSave()
    {
        ScoreInputAchievement::getInstance()->add($this->user_id, $this);
        parent::afterSave();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        if (empty($this->entity_id))
            return $this->award->title . ' ' . Yii::app()->dateFormatter->format('MMMM yyyy', strtotime($this->created) - 3600 * 24 * 2);
        else
            return $this->award->title;
    }

    /**
     * @param int $user_id
     * @return ScoreUserAchievement[]
     */
    public static function getUserAchievements($user_id)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('t.user_id', $user_id);
        $criteria->order = 't.id desc';
        $criteria->with = array('achievement');

        return self::model()->findAll($criteria);
    }

    /**
     * Возвращает модель награды
     * @return ScoreAchievement
     */
    public function getAward()
    {
        return $this->achievement;
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('/profile/default/award', array('id' => $this->id, 'user_id' => $this->user_id, 'type' => 'achievement'));
    }
}