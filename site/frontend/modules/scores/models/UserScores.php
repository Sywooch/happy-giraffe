<?php

/**
 * This is the model class for table "score__user_scores".
 *
 * The followings are the available columns in table 'score__user_scores':
 * @property string $user_id
 * @property string $scores
 * @property string $level_id
 * @property integer $full
 *
 * The followings are the available model relations:
 * @property ScoreLevels $level
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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id', 'required'),
            array('full', 'numerical', 'integerOnly' => true),
            array('user_id, scores, level_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('user_id, scores, level_id, full', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'level' => array(self::BELONGS_TO, 'ScoreLevels', 'level_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'scores' => 'Scores',
            'level_id' => 'Level',
            'full' => 'Full',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('scores', $this->scores, true);
        $criteria->compare('level_id', $this->level_id, true);
        $criteria->compare('full', $this->full);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function beforeSave()
    {
        /*if ($this->scores >= 100 && empty($this->level_id)) {
            $this->level_id = 1;
            UserAction::model()->add($this->user_id, UserAction::USER_ACTION_LEVELUP, $this->getAttributes(array('level_id')));
        }*/
        return parent::beforeSave();
    }

    /**
     * @static
     * @param int $user_id
     * @param int $action_id
     * @param int $count
     * @param CActiveRecord|array $entity
     */
    public static function addScores($user_id, $action_id, $count = 1, $entity = null)
    {
        //проверяем нужно ли добавить действие к существующему такому же, которое было недавно
        $input = ScoreInput::model()->getActiveScoreInput($user_id, $action_id, $entity);
        $score_value = ScoreAction::getActionScores($action_id);

        if ($input === null) {
            $input = new ScoreInput();
            $input->action_id = (int)$action_id;
            $input->user_id = (int)$user_id;
        }
        $input->addItem($score_value, $count, $entity);
        $input->save();
    }

    /**
     * @static
     * @param int $user_id
     * @param int $action_id
     * @param int $count
     * @param CActiveRecord|array $entity
     * @return void
     */
    public static function removeScores($user_id, $action_id, $count = 1, $entity = null)
    {
        //проверяем нужно ли удалить действие из существующего такого же, которое было недавно
        $input = ScoreInput::model()->getActiveScoreInput($user_id, $action_id, $entity);
        $score_value = ScoreAction::getActionScores($action_id);

        if ($input === null) {
            $input = new ScoreInput();
            $input->action_id = (int)$action_id;
            $input->user_id = (int)$user_id;
        }
        $input->removeItem($score_value, $count, $entity);
        $input->save();
    }

    /**
     * @static
     * @param Rating $model
     * @param $entity
     * @param $social_key
     * @param $value
     * @return void
     */
    public static function checkViewsAndComments($model, $entity, $social_key, $value)
    {
        if (isset($entity->author_id)) {
            if ($social_key == 'cm') {
                if (isset($model->ratings[$social_key]))
                    $prev = $model->ratings[$social_key];
                else
                    $prev = 0;

                $diff = floor($value / 10) - floor($prev / 10);
                if ($diff >= 1) {
                    self::addScores($entity->author_id, ScoreAction::ACTION_10_COMMENTS, $diff, $entity);
                }
                if ($diff <= -1) {
                    self::removeScores($entity->author_id, ScoreAction::ACTION_10_COMMENTS, abs($diff), $entity);
                }
            } elseif ($social_key == 'vw') {
                if (isset($model->ratings[$social_key]))
                    $prev = $model->ratings[$social_key];
                else
                    $prev = 0;

                $diff = floor($value / 100) - floor($prev / 100);
                if ($diff >= 1) {
                    self::addScores($entity->author_id, ScoreAction::ACTION_100_VIEWS, $diff, $entity);
                }
                if ($diff <= -1) {
                    self::removeScores($entity->author_id, ScoreAction::ACTION_100_VIEWS, abs($diff), $entity);
                }
            }
        }
    }

    /**
     * @static
     * @param int $user_id
     * @param int $action_id
     * @return void
     */
    public static function checkProfileScores($user_id, $action_id)
    {
        $model = self::model()->findByPk($user_id);
        if ($model->full == 0) {
            $score = ScoreInput::model()->findByAttributes(array(
                'action_id' => (int)$action_id,
                'user_id' => (int)$user_id
            ));
            if ($score === null)
                self::addScores($user_id, $action_id);

            $model->checkFull();
        }
    }

    public function checkFull()
    {
        if ($this->getStepsCount() >= 6) {
            $this->full = 1;
            $this->level_id = 1;
            UserAction::model()->add($this->user_id, UserAction::USER_ACTION_LEVELUP, array('level_id' => 1));
            $this->save();
            self::addScores($this->user_id, ScoreAction::ACTION_PROFILE_FULL);
        }
    }

    public function getStepsCount()
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('user_id', '==', (int)$this->user_id);
        $criteria->addCond('action_id', 'in', array(ScoreAction::ACTION_PROFILE_BIRTHDAY,
            ScoreAction::ACTION_PROFILE_PHOTO, ScoreAction::ACTION_PROFILE_FAMILY,
            ScoreAction::ACTION_PROFILE_INTERESTS, ScoreAction::ACTION_PROFILE_EMAIL,
            ScoreAction::ACTION_PROFILE_LOCATION));
        return ScoreInput::model()->count($criteria);
    }

    public function stepComplete($step_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('user_id', '==', (int)$this->user_id);
        $criteria->addCond('action_id', '==', (int)$step_id);
        return ScoreInput::model()->count($criteria) >= 1;
    }

    public function getUserHistory(){
        $criteria = new EMongoCriteria;
        $criteria->addCond('user_id', '==', (int)$this->user_id);
        $criteria->addCond('status', '==', ScoreInput::STATUS_CLOSED);
        $criteria->sort('updated', EMongoCriteria::SORT_DESC);
        $dataProvider = new EMongoDocumentDataProvider('ScoreInput',array('criteria'=> $criteria));

        return $dataProvider;
    }
}