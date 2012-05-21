<?php

/**
 * This is the model class for table "shop__product_items".
 *
 * The followings are the available columns in table 'shop__product_items':
 * @property string $id
 * @property string $product_id
 * @property string $properties
 * @property integer $count
 * @property float $price
 *
 * The followings are the available model relations:
 * @property Product $product
 */
class ProductItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductItem the static model class
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
		return 'shop__product_items';
	}

	/**
	 * @return array validation rules for model properties.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those properties that
		// will receive user inputs.
		return array(
			array('product_id, properties, count', 'required'),
			array('count, product_id', 'numerical', 'integerOnly'=>true),
            array('price', 'numerical'),
			array('product_id', 'length', 'max'=>10),
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
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'properties' => 'properties',
			'count' => 'Count',
		);
	}

    public function getParams()
    {
        $params = unserialize($this->properties);
        $p = array();
        $i = 0;
        foreach($params as $var => $val)
        {
            if(!$attr = Attribute::model()->findByPk($var))
                continue;
            $p[$i] = array();
            $p[$i]['attribute'] = $attr;
            if ($attr->attribute_type == Attribute::TYPE_BOOL)
                $value = $val == 1 ? 'Да' : 'Нет';
            elseif ($attr->attribute_type == Attribute::TYPE_ENUM || $attr->attribute_type == Attribute::TYPE_MEASURE || $attr->attribute_type == Attribute::TYPE_TEXT)
                $value = AttributeValue::model()->findByPk($val)->value_value;
            else
                $value = false;
            $p[$i]['value'] = $value;
            $i++;
        }
        return $p;
    }

    public function beforeSave()
    {
        if(!$this->isNewRecord)
            return parent::beforeSave();
        $this->properties = serialize($this->properties);
        $criteria = new CDbCriteria;
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('properties', $this->properties);
        if($pi = ProductItem::model()->find($criteria))
        {
            $pi->count += $this->count;
            $pi->price = $this->price;
            $pi->save();
            return false;
        }
        return parent::beforeSave();
    }
}