<?php

/**
 * This is the model class for table "product_set_map".
 *
 * The followings are the available columns in table 'product_set_map':
 * @property string $map_id
 * @property string $map_set_id
 * @property string $map_product_id
 * @property string $map_product_count
 */
class ProductSetMap extends HActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductSetMap the static model class
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
		return 'shop__product_set_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('map_product_id, map_product_count', 'required'),

			array('map_set_id, map_product_id', 'length', 'max' => 10),
			array('map_product_count', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 255),

			array('map_product_id','uniq'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('map_id, map_set_id, map_product_id', 'safe', 'on' => 'search'),
		);
	}

	public function uniq($attribute, $attributes)
	{
		$map = Y::command()
			->select('map_id')
			->from($this->tableName())
			->where('map_set_id=:map_set_id AND map_product_id=:map_product_id', array(
				':map_set_id'=>$this->map_set_id,
				':map_product_id'=>$this->map_product_id,
			))
			->limit(1)
			->queryScalar();

		if($map)
		{
			$msg = 'Product alrady exists in this set.';
			$this->addError('map_product_id', $msg);
			Y::errorFlash($msg);
		}
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
			'map_id' => 'Map',
			'map_set_id' => 'Map Set',
			'map_product_id' => 'Map Product',
			'map_product_count' => 'Map Count',
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

		$criteria = new CDbCriteria;

		$criteria->compare('map_id', $this->map_id, true);
		$criteria->compare('map_set_id', $this->map_set_id, true);
		$criteria->compare('map_product_id', $this->map_product_id, true);
		$criteria->compare('map_product_count', $this->map_product_count);

		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
			));
	}
	
	/**
	 * Get products by map_set_id
	 * @param int $setId
	 * @return array
	 */
	public function getProductsBySetId($setId) { 
		$command = Yii::app()->db->createCommand();
		$command->select('product_title,product_image,map_id AS id, map_product_count')
				->from($this->tableName())
				->leftJoin(Product::model()->tableName(), 'map_product_id=product_id')
				->where('map_set_id=:map_set_id');
		$command->params = array(
			':map_set_id' => (int) $setId,
		);
		return $command->queryAll();
	}

}