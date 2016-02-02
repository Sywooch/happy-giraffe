<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__answers_votes".
 *
 * The followings are the available columns in table 'qa__answers_votes':
 * @property int $answerId
 * @property int $userId
 * @property int $dtimeCreate
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\qa\models\QaAnswer $answer
 */
class QaAnswerVote extends \CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__answers_votes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('answerId, userId', 'safe'),
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
			'answer' => array(self::BELONGS_TO, '\site\frontend\modules\som\modules\qa\models\QaAnswer', 'answerId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'answerId' => 'Answer',
			'userId' => 'User',
			'dtimeCreate' => 'Dtime Create',
		);
	}

	public function behaviors()
	{
		return array(
			'HTimestampBehavior' => array(
				'class' => 'HTimestampBehavior',
				'createAttribute' => 'dtimeCreate',
			),
		);
	}

	public function answers($answers)
	{
		$this->getDbCriteria()->addInCondition($this->tableAlias . '.answerId', array_map(function(QaAnswer $answer) {
			return $answer->id;
		}, $answers));
		return $this;
	}

	public function user($userId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.userId', $userId);
		return $this;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaAnswerVote the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}