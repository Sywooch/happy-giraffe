<?php

/**
 * This is the model class for table "{{product_pricelist_set_map}}".
 *
 * The followings are the available columns in table '{{product_pricelist_set_map}}':
 * @property string $map_id
 * @property string $map_set_id
 * @property string $map_product_id
 * @property string $map_pricelist_id
 * @property string $map_set_price
 */
class ProductPricelistSetMap extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductPricelistSetMap the static model class
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
		return 'shop__product_pricelist_set_map';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('map_product_id, map_pricelist_id, map_set_price', 'required'),
			array('map_product_id, map_set_id, map_pricelist_id, map_set_price', 'length', 'max'=>10),

			array('map_product_id','uniq'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('map_id, map_set_id, map_pricelist_id, map_set_price', 'safe', 'on'=>'search'),
		);
	}

	public function uniq($attribute, $attributes)
	{
		
		if(!$this->getIsNewRecord())
			return;
		$map = $this->find('map_product_id = :map_product_id AND map_pricelist_id = :map_pricelist_id', array(
			':map_product_id'=>$this->map_product_id,
			':map_pricelist_id'=>$this->map_pricelist_id
		));
		if($map)
		{
			$msg = 'Product alrady exists in this pricelist.';
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
			'product'=>array(self::BELONGS_TO,'Product','map_product_id'),
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
			'map_pricelist_id' => 'Map Pricelist',
			'map_set_price' => 'Map Set Price',
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

		$criteria->compare('map_id',$this->map_id);
		$criteria->compare('map_set_id',$this->map_set_id);
		$criteria->compare('map_product_id',$this->map_product_id);
		$criteria->compare('map_pricelist_id',$this->map_pricelist_id);
		$criteria->compare('map_set_price',$this->map_set_price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getProductByMapPricelistId($productId, $mapId) { 
		$command = Yii::app()->db->createCommand();
		$command->select('map_id, map_product_id, map_set_price, product_title')
				->leftJoin(Product::model()->tableName(), 'map_product_id=product_id')
				->where('map_product_id = :map_product_id AND map_pricelist_id = :map_pricelist_id');
		$command->params = array(
			':map_product_id' => $productId,
			':map_pricelist_id'=>$mapId,
		);
		return $command->queryRow();
	}
	
	public function getByMapPricelistId($mapPricelistId) { 
		return ProductPricelistSetMap::model()->findAll('map_pricelist_id = :map_pricelist_id', array(
			':map_pricelist_id' => (int) $mapPricelistId
		));
	}
}