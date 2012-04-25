<?php

/**
 * This is the model class for table "{{product_set}}".
 *
 * The followings are the available columns in table '{{product_set}}':
 * @property string $set_id
 * @property string $set_title
 * @property string $set_text
 */
class ProductSet extends HActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductSet the static model class
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
		return 'shop__product_set';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('set_title', 'required'),
			array('set_title', 'length', 'max'=>250),
			array('set_text', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('set_id, set_title, set_text', 'safe', 'on'=>'search'),
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
			'set_id' => 'Set',
			'set_title' => 'Set Title',
			'set_text' => 'Set Text',

			'price' => 'Set Price',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($crit=null)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('set_id',$this->set_id);
		$criteria->compare('set_title',$this->set_title,true);
		$criteria->compare('set_text',$this->set_text,true);

		if($crit)
			$criteria->mergeWith($crit);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 *
	 * @param string $val
	 * @param CDbCriteria $criteria
	 */
	public function listAll($val='set_title',$criteria=null)
	{
		$list = Y::command()
			->select(array('set_id',$val))
			->from($this->tableName());

		if($criteria && $criteria instanceof CDbCriteria)
		{
			$array = $criteria->toArray();
			if($array['condition'])
				$list = $list->where($array['condition'], $array['params']);
		}

		$list = $list->queryAll();

		return CHtml::listData($list, 'set_id', $val);
	}

	public function getPrice($pricelist_id)
	{
		return Y::command()
			->select('map_set_price')
			->from(ProductPricelistSetMap::model()->tableName())
			->where('map_set_id=:map_set_id AND map_pricelist_id=:map_pricelist_id', array(
				':map_pricelist_id'=>$pricelist_id,
				':map_set_id'=>$this->set_id,
			))
			->queryScalar();
	}

	protected function beforeDelete()
	{
		Y::command()->delete(ProductPricelistSetMap::model()->tableName(), 'map_set_id=:map_set_id', array(
			':map_set_id'=>$this->set_id,
		));
		return parent::beforeDelete();
	}
}