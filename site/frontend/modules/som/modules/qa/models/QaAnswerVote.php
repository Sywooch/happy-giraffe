<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__answers_votes".
 *
 * The followings are the available columns in table 'qa__answers_votes':
 * @property string $answerId
 * @property string $userId
 * @property string $dtimeCreate
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
