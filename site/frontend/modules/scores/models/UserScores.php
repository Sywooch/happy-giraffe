<?php

/**
 * This is the model class for table "user_scores".
 *
 * The followings are the available columns in table 'user_scores':
 * @property string $user_id
 * @property string $scores
 * @property string $level_id
 *
 * The followings are the available model relations:
 * @property ScoreLevels $level
 * @property User $user
 */
class UserScores extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserScores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_scores';
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
			array('user_id, scores, level_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, scores, level_id', 'safe', 'on'=>'search'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('scores',$this->scores,true);
		$criteria->compare('level_id',$this->level_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function addScores($user_id, $action_id)
    {
        //проверяем не нужно ли инкрементировать предыдущее событие
        $last_action = ScoreInput::model()->getLastAction($user_id);
        if ($last_action->action_id == $action_id && ($last_action->created + 3600 > time())){
            //инкрементируем
            $last_action->inc();
            $last_action->save();
        }else{
            $input = new ScoreInput();
            $input->action_id = $action_id;
            $input->scores_earned = ScoreActions::getActionScores($action_id);
            $input->save();
        }
    }
}