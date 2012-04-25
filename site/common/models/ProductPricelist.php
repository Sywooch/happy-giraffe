<?php

/**
 * This is the model class for table "{{product_pricelist}}".
 *
 * The followings are the available columns in table '{{product_pricelist}}':
 * @property string $pricelist_id
 * @property string $pricelist_title
 * @property string $price_list_settings
 */
class ProductPricelist extends HActiveRecord
{
	public $pricelist_by;
	
	public $multiply = 100;
	
	private $create_map = false;

	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductPricelist the static model class
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
		return 'shop__product_pricelist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pricelist_title', 'required'),
			
			array('pricelist_title, pricelist_by, multiply' ,'required', 'on'=>'by'),
			array('pricelist_by' ,'numerical', 'integerOnly'=>true, 'on'=>'by'),
			array('multiply' ,'numerical', 'integerOnly'=>false, 'min'=>1, 'max'=>100, 'on'=>'by'),
			array('pricelist_by' ,'exis', 'on'=>'by'),

			array('pricelist_title', 'length', 'max'=>250),
			array('price_list_settings', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('pricelist_id, pricelist_title, price_list_settings', 'safe', 'on'=>'search'),
		);
	}
	
	public function exis($attribute, $params)
	{
		if(!array_key_exists($this->$attribute, $this->listAll()))
			$this->addError($attribute, 'Please select existing pricelist');
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
			'pricelist_id' => 'Pricelist',
			'pricelist_title' => 'Pricelist Title',
			'price_list_settings' => 'Price List Settings',
			
			'pricelist_by' => 'By Price',
			'multiply' => 'Multiply, %',
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

		$criteria->compare('pricelist_id',$this->pricelist_id,true);
		$criteria->compare('pricelist_title',$this->pricelist_title,true);
		$criteria->compare('price_list_settings',$this->price_list_settings,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeDelete()
	{
		Y::command()->delete(ProductPricelistSetMap::model()->tableName(), 'map_pricelist_id=:map_pricelist_id', array(
			':map_pricelist_id'=>$this->pricelist_id,
		));
		return parent::beforeDelete();
	}
	
	protected function beforeSave()
	{
		if($this->getScenario() == 'by')
			$this->create_map = true;
		
		return parent::beforeSave();
	}
	
	protected function afterSave()
	{
		if($this->create_map)
			$this->createMapsBy();
		
		parent::afterSave();
	}
			

	private function createMapsBy()
	{
		$table = ProductPricelistSetMap::model()->tableName();
		Y::command()
			->delete($table,
				'map_pricelist_id=:map_pricelist_id',
				array(
					':map_pricelist_id'=>$this->pricelist_id,
				));
		
		$sql = "INSERT INTO $table (map_pricelist_id, map_product_id, map_set_price)
		SELECT '{$this->pricelist_id}', map_product_id, {$this->multiply}/100*map_set_price
		FROM $table
		WHERE map_pricelist_id=:map_pricelist_id";
		Y::command($sql)->execute(array(
			':map_pricelist_id'=>$this->pricelist_by,
		));
	}

	public function listAll()
	{
		$list = Y::db()
			->cache(60)
			->createCommand()
			->select('pricelist_id, pricelist_title')
			->from($this->tableName())
			->queryAll();

		return CHtml::listData($list, 'pricelist_id', 'pricelist_title');
	}
}