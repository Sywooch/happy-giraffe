<?php

/**
 * This is the model class for table "{{product_attribute}}".
 *
 * The followings are the available columns in table '{{product_attribute}}':
 * @property string $attribute_id
 * @property string $attribute_title
 * @property string $attribute_text
 * @property integer $attribute_type
 * @property integer $attribute_required
 * @property integer $attribute_is_insearch
 * @property integer $price_influence
 * @property integer $attribute_in_price
 * @property integer $measure_option_id
 *
 * @property AttributeMeasureOption $measure_option
 * @property AttributeValueMap[] $value_map
 */
class Attribute extends HActiveRecord
{
	const TYPE_ENUM = 1;
    const TYPE_INTG = 2;
    const TYPE_MEASURE = 3;
	const TYPE_TEXT = 5;
	const TYPE_BOOL = 6;

	public function behaviors()
	{
        return array(
            'types' => array(
                'class' => 'site.frontend.extensions.status.EStatusBehavior',
                'statusField' => 'attribute_type',
                'statuses' => array(
					self::TYPE_ENUM => 'Список',
					self::TYPE_INTG => 'Число',
					self::TYPE_MEASURE => 'Единицы измерения',
					self::TYPE_TEXT => 'Текст',
					self::TYPE_BOOL => 'Да-Нет',
				),
            ),
        );
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return Attribute the static model class
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
		return 'shop__product_attribute';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('attribute_type, attribute_required, attribute_is_insearch, attribute_title', 'required'),
			array('attribute_type, attribute_required, attribute_is_insearch, price_influence, attribute_in_price, measure_option_id', 'numerical', 'integerOnly'=>true),
			array('attribute_title', 'length', 'max'=>50),
			array('attribute_text', 'safe'),

			array('attribute_title', 'length', 'max'=>50),
			array('attribute_is_insearch, price_influence, attribute_in_price', 'default', 'value' => 0),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('attribute_id, attribute_title, attribute_text, attribute_type, attribute_in_price, type, attribute_required, attribute_is_insearch, price_influence', 'safe', 'on'=>'search'),
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
            'value_map' => array(self::HAS_MANY, 'AttributeValueMap', 'map_attribute_id'),
            'measure_option' => array(self::BELONGS_TO, 'AttributeMeasureOption', 'measure_option_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'attribute_id' => 'Attribute',
			'attribute_title' => 'Attribute Title',
			'attribute_text' => 'Attribute Text',
			'attribute_type' => 'Attribute Type',
			'type' => 'Attribute Type',
			'attribute_required' => 'Обязателен',
			'attribute_is_insearch' => 'Поиск по атрибуту',
            'price_influence'=>'Влияет на цену',
			'categoryInSearch' => 'Is Category In Search',
            'attribute_in_price'=>'В корзину'
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

		$criteria->compare('attribute_id',$this->attribute_id);
		$criteria->compare('attribute_title',$this->attribute_title,true);
		$criteria->compare('attribute_text',$this->attribute_text,true);
		$criteria->compare('attribute_type',$this->attribute_type);
		$criteria->compare('attribute_required',$this->attribute_required);
		$criteria->compare('attribute_is_insearch',$this->attribute_is_insearch);
        $criteria->compare('price_influence',$this->price_influence);
//		Y::dump($this->attributes, false);
		
		if($crit)
			$criteria->mergeWith($crit);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getType()
	{
		return $this->types->getStatusText();
	}
	
	public function setType($val)
	{
		$this->attribute_type = $val;
	}

	protected function beforeDelete()
	{
		$avm = new AttributeValueMap;

		Yii::app()->db->createCommand()
			->delete($avm->tableName(), 'map_attribute_id=:map_attribute_id', array(
				':map_attribute_id'=>$this->attribute_id,
			));

		$asm = new AttributeSetMap;

		Yii::app()->db->createCommand()
			->delete($asm->tableName(), 'map_attribute_id=:map_attribute_id', array(
				':map_attribute_id'=>$this->attribute_id,
			));

		return parent::beforeDelete();
	}

	/**
	 * Find is this attribute in search in this category
	 * @param int $category_id 
	 * @return boolean
	 */
	public function getCategoryInSearch($category_id)
	{
		static $insearch;
		
		$name = $category_id .'_' . $this->attribute_id;
		
		if(isset($insearch[$name]))
			return $insearch[$name];

		$insearch[$name] = (boolean) Y::db()
			->createCommand()
			->select('map_in_search')
			->from('shop_category_attributes_map')
			->where('map_category_id=:map_category_id AND map_attribute_id=:map_attribute_id', array(
				':map_category_id' => $category_id,
				':map_attribute_id' => $this->attribute_id,
			))
			->limit(1)
			->queryScalar();
		
		return $insearch[$name];
	}
	
	public function listAll($term='',$val='attribute_title')
	{
		if(!is_array($val))
		{
			$val = explode(',', $val);
			
			foreach ($val as $k=>$v)
			{
				if(($v=trim($v)))
					$val[$k] = $v;
				else
					unset($val[$k]);
			}
		}
		
		if(!$val)
			return array();
		
		$command = Y::command()
			->select(array_merge($val, array('attribute_id')))
			->from('shop__product_attribute');
		
		if($term && is_string($term))
		{
			$command->where(array('and', 
				array('like','attribute_title',"%$term%"),
				array('like','attribute_text',"%$term%")
			));
		}
		
		return $command->queryAll();
	}

    /**
     * @return array
     */
    public function GetEnumList(){
        $models = AttributeValueMap::model()->with(array(
            'map_value'
        ))->findAll('map_attribute_id='.$this->attribute_id);

        $res = array();
        foreach ($models as $model) {
            $res [] = $model->map_value;
        }

        return CHtml::listData($res, 'value_id', 'value_value');
    }
}