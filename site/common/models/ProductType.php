<?php

/**
 * This is the model class for table "{{product_type}}".
 *
 * The followings are the available columns in table '{{product_type}}':
 * @property string $type_id
 * @property string $type_title
 * @property string $type_text
 * @property string $type_image
 * @property string $type_time
 * @property string $type_attribute_set_id
 *
 * @method array getAllSets() getAllSets() return all attribute sets
 * @method string getSetTitle() getSetTitle() return attribute set title
 */
class ProductType extends HActiveRecord
{
	public function behaviors()
	{
		return array(
			'behavior_ufiles' => array(
				'class' => 'ext.ufile.UFileBehavior',
				'fileAttributes'=>array(
					'type_image'=>array(
						'fileName'=>'upload/product_type/<date>-{type_id}-<name>.<ext>',
						'fileItems'=>array(
							array('fileHandler'=>array(__CLASS__,'ufileHandler'), 'W'=>100,'H'=>100),
						)
					),
				),
			),
			'attribute_set' => array(
				'class'=>'attribute.AttributeSetBehavior',
				'table'=>'shop__product_attribute_set',
				'attribute'=>'type_attribute_set_id',
			),
		);
	}
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductType the static model class
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
		return 'shop__product_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type_title, type_image', 'required'),

			array('type_image', 'ext.ufile.UFileValidator',
				'allowedTypes'=>'jpg, gif, png',
//				'minWidth'=>621, 'minHeight'=>424,
				'allowEmpty'=>false
			),

			array('type_title', 'length', 'max'=>150),
			array('type_image', 'length', 'max'=>250),
			array('type_time, type_attribute_set_id', 'length', 'max'=>10),
			array('type_text', 'safe'),

			array('type_time', 'default', 'value' => time()),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('type_id, type_title, type_text, type_image, type_time, type_attribute_set_id', 'safe', 'on'=>'search'),
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
			'type_id' => 'Type',
			'type_title' => 'Type Title',
			'type_text' => 'Type Text',
			'type_image' => 'Type Image',
			'type_time' => 'Type Time',
			'type_attribute_set_id' => 'Type Attribute Set',
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

		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('type_title',$this->type_title,true);
		$criteria->compare('type_text',$this->type_text,true);
		$criteria->compare('type_image',$this->type_image,true);
		$criteria->compare('type_time',$this->type_time,true);
		$criteria->compare('type_attribute_set_id',$this->type_attribute_set_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function ufileHandler($src, $dst, $params)
	{
		Yii::import('application.extensions.image.Image');
		Yii::import('ext.helpers.CArray');
		Image::factory($src)
			->resize($params['W'], $params['H'])
			->quality(90)
			->save($dst, false);
	}

	protected function beforeDelete()
	{
		$product = new Product;
		$product_id = Y::command()->select('product_id')
			->from($product->tableName())
			->where('product_type_id=:product_type_id', array(
				':product_type_id'=>$this->type_id,
			))
			->queryScalar();
		if($product_id)
		{
			Y::errorFlash("Can't delete this type. Product exists.");
			return false;
		}

		return parent::beforeDelete();
	}

	public function listAll($val='type_title')
	{
		$list = Y::command()
			->select(array('type_id',$val))
			->from($this->tableName())
			->queryAll();

		return CHtml::listData($list, 'type_id', $val);
	}
}