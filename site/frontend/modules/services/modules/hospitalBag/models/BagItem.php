<?php

/**
 * This is the model class for table "bag_item".
 *
 * The followings are the available columns in table 'bag_item':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property integer $approved
 * @property integer $for
 * @property string $category_id
 */
class BagItem extends HActiveRecord
{
	const FOR_MUM = 0;
	const FOR_CHILD = 1;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return BagItem the static model class
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
		return 'bag__items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('for, category_id', 'required'),
            array('title', 'required', 'message'=>'Напишите, что ещё нужно взять в роддом'),
            array('description', 'required', 'message'=>'А для чего это нужно?'),
			array('title', 'length', 'max' => 255),
			array('approved, for', 'boolean'),
			array('category_id', 'numerical', 'integerOnly' => true),
			array('category_id', 'length', 'max' => 11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, approved, for, category_id', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'BagCategory', 'category_id'),
			'offer' => array(self::HAS_ONE, 'BagOffer', 'item_id', 'condition' => 'approved = 0'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Название предмета',
			'description' => 'Описание предмета',
			'approved' => 'Approved',
			'for' => 'For',
			'category_id' => 'Category',
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
		$criteria->compare('title',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('for',$this->for);
		$criteria->compare('category_id',$this->category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}