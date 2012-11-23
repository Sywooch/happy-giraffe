<?php

/**
 * This is the model class for table "sites__group_sites".
 *
 * The followings are the available columns in table 'sites__group_sites':
 * @property integer $group_id
 * @property integer $site_id
 *
 * The followings are the available model relations:
 * @property Site $group
 * @property Site $site
 */
class GroupSites extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GroupSites the static model class
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
		return 'sites__group_sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, site_id', 'required'),
			array('group_id, site_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('group_id, site_id', 'safe', 'on'=>'search'),
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
			'group' => array(self::BELONGS_TO, 'Site', 'group_id'),
			'site' => array(self::BELONGS_TO, 'Site', 'site_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'group_id' => 'Group',
			'site_id' => 'Site',
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

		$criteria->compare('group_id',$this->group_id);
		$criteria->compare('site_id',$this->site_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}