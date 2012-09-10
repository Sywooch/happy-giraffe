<?php

/**
 * This is the model class for table "externallinks__tasks".
 *
 * The followings are the available columns in table 'externallinks__tasks':
 * @property string $id
 * @property string $site_id
 * @property integer $type
 * @property string $user_id
 * @property string $created
 * @property string $closed
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property ELSite $site
 */
class ELTask extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ELTask the static model class
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
		return 'externallinks__tasks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_id, type, user_id, created, closed', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('site_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, site_id, type, user_id, created, closed', 'safe', 'on'=>'search'),
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
			'site' => array(self::BELONGS_TO, 'ELSite', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'site_id' => 'Site',
			'type' => 'Type',
			'user_id' => 'User',
			'created' => 'Created',
			'closed' => 'Closed',
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
		$criteria->compare('site_id',$this->site_id,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('closed',$this->closed,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}