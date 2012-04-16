<?php

/**
 * This is the model class for table "vaccine_disease".
 *
 * The followings are the available columns in table 'vaccine_disease':
 * @property integer $id
 * @property string $name
 * @property string $name_genitive
 * @property string $disease_id
 *
 * The followings are the available model relations:
 * @property VaccineDate[] $vaccineDates
 * @property RecipebookDisease $disease
 */
class VaccineDisease extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VaccineDisease the static model class
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
		return 'vaccine__diseases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, name_genitive', 'required'),
			array('name', 'length', 'max'=>256),
			array('name_genitive', 'length', 'max'=>255),
			array('disease_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, name_genitive, disease_id', 'safe', 'on'=>'search'),
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
			'vaccineDates' => array(self::MANY_MANY, 'VaccineDate', 'vaccine__dates_diseases(vaccine_disease_id, vaccine_date_id)'),
			'disease' => array(self::BELONGS_TO, 'RecipeBookDisease', 'disease_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'name_genitive' => 'Name Genitive',
			'disease_id' => 'Disease',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('name_genitive',$this->name_genitive,true);
		$criteria->compare('disease_id',$this->disease_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}