<?php

/**
 * This is the model class for table "shop__product_eav_text".
 *
 * The followings are the available columns in table 'shop__product_eav_text':
 * @property string $eav_id
 * @property string $eav_product_id
 * @property string $eav_attribute_id
 * @property integer $value_id
 *
 * The followings are the available model relations:
 * @property ShopProductAttribute $eavAttribute
 * @property ShopProduct $eavProduct
 */
class ProductEavText extends HActiveRecord
{
    public $eav_attribute_value;
	/**
	 * Returns the static model of the specified AR class.
	 * @return ProductEavText the static model class
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
		return 'shop__product_eav_text';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('eav_product_id, eav_attribute_id', 'required'),
			array('eav_product_id, eav_attribute_id, value_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('eav_id, eav_product_id, eav_attribute_id', 'safe', 'on'=>'search'),
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
			'eavAttribute' => array(self::BELONGS_TO, 'ShopProductAttribute', 'eav_attribute_id'),
			'eavProduct' => array(self::BELONGS_TO, 'ShopProduct', 'eav_product_id'),
		);
	}


	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'eav_id' => 'Eav',
			'eav_product_id' => 'Eav Product',
			'eav_attribute_id' => 'Eav Attribute',
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

		$criteria->compare('eav_id',$this->eav_id,true);
		$criteria->compare('eav_product_id',$this->eav_product_id,true);
		$criteria->compare('eav_attribute_id',$this->eav_attribute_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeSave()
    {
        $value = $this->eav_attribute_value;
        $result = Y::command()->select("id, value")->from("shop__product_eav_text_values")
            ->where('value = :value');
        $result->params = array(":value" => $value);
        $result = $result->queryRow();
        if($result)
        {
            $this->value_id = $result['id'];
        }
        else
        {
            Y::command()->insert('shop__product_eav_text_values', array('value' => $value));
            $result = Y::command()->select("id, value")->from("shop__product_eav_text_values")
                ->where('value = :value');
            $result->params = array(":value" => $value);
            $result = $result->queryRow();
            $this->value_id = $result['id'];
        }
        return parent::beforeSave();
    }
}