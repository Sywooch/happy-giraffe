<?php
namespace site\frontend\modules\som\modules\qa\models;

/**
 * This is the model class for table "qa__users_rating".
 *
 * The followings are the available columns in table 'qa__users_rating':
 * @property string $userId
 * @property string $type
 * @property integer $questionsCount
 * @property integer $answersCount
 * @property double $rating
 * @property integer $position
 *
 * @property \site\frontend\components\api\models\User $user
 */
class QaUserRating extends \HActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'qa__users_rating';
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

	public function apiRelations()
	{
		return array(
			'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => 'User',
			'type' => 'Type',
			'questionsCount' => 'Questions Count',
			'answersCount' => 'Answers Count',
			'rating' => 'Rating',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return QaUserRating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function type($type)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.type', $type);
		return $this;
	}

	public function orderPosition()
	{
		$this->getDbCriteria()->order = $this->tableAlias . '.rating DESC';
		return $this;
	}

	public function user($userId)
	{
		$this->getDbCriteria()->compare($this->tableAlias . '.userId', $userId);
		return $this;
	}
}
