<?php

/**
 * This is the model class for table "score__actions".
 *
 * The followings are the available columns in table 'score__actions':
 * @property string $id
 * @property string $title
 * @property integer $scores_weight
 * @property integer $wait_time
 */
class ScoreAction extends HActiveRecord
{
    const ACTION_PROFILE_BIRTHDAY = 30;
    const ACTION_PROFILE_PHOTO = 31;
    const ACTION_PROFILE_FAMILY = 32;
    const ACTION_PROFILE_INTERESTS = 33;
    const ACTION_PROFILE_LOCATION = 34;
    const ACTION_PROFILE_EMAIL = 35;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreAction the static model class
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
        return 'score__actions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, scores_weight', 'required'),
            array('scores_weight, wait_time', 'numerical', 'integerOnly' => true),
            array('id', 'length', 'max' => 10),
            array('title', 'length', 'max' => 256),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, scores_weight, wait_time', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'scores_weight' => 'Scores Weight',
            'wait_time' => 'Wait Time',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('scores_weight', $this->scores_weight);
        $criteria->compare('wait_time', $this->wait_time);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getActionInfo($id)
    {
        $cache_id = 'ScoreAction' . $id;
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {
            $model = self::model()->findByPk($id);
            $value = $model->attributes;
            Yii::app()->cache->set($cache_id, $value, 3600);
        }

        return $value;
    }

    public static function getActionScores($id, $params = array())
    {
        if ($id == ScoreInput::TYPE_AWARD) {
            $award = ScoreAward::model()->findByPk($params['award_id']);
            return $award->scores;
        } elseif ($id == ScoreInput::TYPE_ACHIEVEMENT) {
            $award = ScoreAchievement::model()->findByPk($params['achieve_id']);
            return $award->scores;
        } else {
            $action = self::getActionInfo($id);
            return $action['scores_weight'];
        }
    }
}