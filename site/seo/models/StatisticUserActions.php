<?php

/**
 * This is the model class for table "statistic__user_actions".
 *
 * The followings are the available columns in table 'statistic__user_actions':
 * @property string $id
 * @property string $user_id
 * @property integer $keyword_id
 * @property integer $action_id
 * @property string $created
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property Keyword $keyword
 */
class StatisticUserActions extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StatisticUserActions the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'statistic__user_actions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, keyword_id, action_id, created', 'required'),
			array('keyword_id, action_id', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, keyword_id, action_id, created', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'SeoUser', 'user_id'),
			'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'keyword_id' => 'Keyword',
			'action_id' => 'Action',
			'created' => 'Created',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('keyword_id',$this->keyword_id);
		$criteria->compare('action_id',$this->action_id);
		$criteria->compare('created',$this->created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}