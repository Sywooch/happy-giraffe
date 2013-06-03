<?php

/**
 * This is the model class for table "shop_category_attributes_map".
 *
 * The followings are the available columns in table 'shop_category_attributes_map':
 * @property string $map_id
 * @property string $map_category_id
 * @property string $map_attribute_id
 * @property integer $map_in_search
 */
class CategoryAttributesMap extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return CategoryAttributesMap the static model class
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
		return 'shop__category_attributes_map';
	}
	
	public function primaryKey() {
		return 'map_id';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('map_category_id, map_attribute_id', 'required'),
			array('map_in_search', 'numerical', 'integerOnly'=>true),
			array('map_category_id, map_attribute_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('map_id, map_category_id, map_attribute_id, map_in_search', 'safe', 'on'=>'search'),
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
			'map_id' => 'Map',
			'map_category_id' => 'Map Category',
			'map_attribute_id' => 'Map Attribute',
			'map_in_search' => 'Map In Search',
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

		$criteria->compare('map_id',$this->map_id,true);
		$criteria->compare('map_category_id',$this->map_category_id,true);
		$criteria->compare('map_attribute_id',$this->map_attribute_id,true);
		$criteria->compare('map_in_search',$this->map_in_search);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Mark category  as not in search
	 * i.e. set property map_in_search = 0
	 * @param int $mapCategoryId 
	 * @return void
	 */
	public function categoryNotInSearch($mapCategoryId) 
	{ 
		$this->updateAll(
				array(
					'map_in_search' => 0
				), 
				'map_category_id = :map_category_id', 
				array(
					':map_category_id' => $mapCategoryId
				)
		);
	}
	
	/**
	 * @param int $categoryId
	 * @param array $attributesArray Wil bu used for IN condition
	 * @return void
	 */
	public function setCategoryMapsAttributesInSearch($categoryId, array $attributesArray)
	{
		$ct = new CDbCriteria();
		$ct->addCondition('map_category_id = :map_category_id');
		$ct->addInCondition('map_attribute_id', $attributesArray);
		$ct->params = array(
			':map_category_id' => $categoryId,
		);
		$this->updateAll(array('map_in_search' => 1), $ct);
	}
	
	/**
	 * @param int $categoryId
	 * @param array $attributesArray Wil bu used for IN condition
	 * @return void
	 */
	public function setCategoryMapsAttributesNotInSearch($categoryId, array $attributesArray)
	{
		$ct = new CDbCriteria();
		$ct->addCondition('map_category_id = :map_category_id');
		$ct->addInCondition('map_attribute_id', $attributesArray);
		$ct->params = array(
			':map_category_id' => $categoryId,
		);
		$this->updateAll(array('map_in_search' => 0), $ct);
	}
	
	/**
	 * Get attributes of category which in search
	 * @param int $categoryId map_category_id
	 * @return CategoryAttributesMap[]
	 */
	public function getCategoryAttributesInSearch($categoryId)
	{
		$criteria = new CDbCriteria();
		$criteria->select = 'map_attribute_id';
		$criteria->addCondition('map_category_id = :map_category_id');
		$criteria->addCondition('map_in_search = 1');
		$criteria->params = array(
			':map_category_id' => $categoryId,
		);
		return $this->findAll($criteria);
	}
	
	/**
	 * Unconnetc attribute, i.e. delete it.
	 * @param int $attributeId
	 * @param int $categoryId 
	 * @return void
	 */
	public function unconnectAttribute($attributeId, $categoryId)
	{
		$ct = new CDbCriteria;
		$ct->addCondition('map_category_id = :map_category_id');
		$ct->addCondition('map_attribute_id = :map_attribute_id');
		$ct->params = array(
			':map_category_id' => $categoryId,
			':map_attribute_id' => $attributeId,
		);
		$this->deleteAll($ct);
	}
	
	/**
	 * Add attribute in search
	 * @param int $attributeId
	 * @param int $categoryId 
	 * @return void
	 */
	public function addAttributeInSearch($attributeId, $categoryId)
	{
		$ct = new CDbCriteria;
		$ct->addCondition('map_category_id = :map_category_id');
		$ct->addCondition('map_attribute_id = :map_attribute_id');
		$ct->params = array(
			':map_category_id' => $categoryId,
			':map_attribute_id' => $attributeId,
		);
		$this->updateAll(array('map_in_search' => 1), $ct);
	}
	
	/**
	 * Remove attribute from search
	 * @param int $attributeId
	 * @param int $categoryId 
	 * @return void
	 */
	public function removeAttributeFromSearch($attributeId, $categoryId)
	{
		$ct = new CDbCriteria;
		$ct->addCondition('map_category_id = :map_category_id');
		$ct->addCondition('map_attribute_id = :map_attribute_id');
		$ct->params = array(
			':map_category_id' => $categoryId,
			':map_attribute_id' => $attributeId,
		);
		$this->updateAll(array('map_in_search' => 0), $ct);
	}
	
	public function connectAttributesSet($id, $setId)
	{
		$sql = "
			INSERT IGNORE INTO shop_category_attributes_map (map_category_id, map_attribute_id)
				SELECT $id, map_attribute_id FROM shop__product_attribute_set_map
					WHERE map_set_id=:map_set_id";
		Y::command($sql)->execute(array(
			':map_set_id' => $setId,
		));
	}
	
	public function getByCategory($categoryId)
	{
		
		/**
		 * $attridute_ids = Y::command()
			->select('map_attribute_id')
			->from('shop_category_attributes_map')
			->where('map_category_id=:map_category_id', array(
				':map_category_id'=>$id,
			))
			->queryAll();
		 */
		$ct = new CDbCriteria();
		$ct->addCondition('map_category_id = :map_category_id');
		$ct->params = array(
			':map_category_id' => $categoryId
		);
		return $this->findAll($ct);
	}
		
}