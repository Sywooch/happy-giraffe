<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class AttributeSearchForm extends CFormModel
{
	public $descendants;
	public $sex;
	public $ages;
	public $prices = array(
		'min'=>0,
		'max'=>1000000,
	);
	public $brands;
	
	public $sexList = array(
		0 => 'Для всех',
		1 => 'Мальчик',
		2 => 'Девочка',
	);

	protected $_category_id;
	protected $_descendants;
	protected $_ages;
	protected $_prices;
	protected $_brands;
	
	public function __get($name)
	{
		if($name == 'priceMin')
			return $this->prices['min'];
		
		if($name == 'priceMax')
			return $this->prices['max'];
		
		return parent::__get($name);
	}
	
	public function __set($name, $value)
	{
		if($name == 'priceMin')
		{
			$this->prices['min'] = $value;
			return;
		}
		
		if($name == 'priceMax')
		{
			$this->prices['max'] = $value;
			return;
		}
		
		parent::__set($name, $value);
	}


	public function rules()
	{
		return array(
			array('descendants', 'rangeValidator', 'allowEmpty' => true, 'range' => $this->_descendants, 'message' => 'Ошибка выбора подкатегории'),
			array('sex', 'rangeValidator', 'allowEmpty' => true, 'range' => $this->sexList, 'message' => 'Ошибка выбора пола'),
			array('ages', 'rangeValidator', 'allowEmpty' => true, 'range' => CHtml::listData($this->_ages, 'id', 'id'), 'message' => 'Ошибка выбора возвраста'),
			array('brands', 'rangeValidator', 'allowEmpty' => true, 'range' => CHtml::listData($this->_brands, 'brand_id', 'brand_id'), 'message' => 'Ошибка выбора бренда'),
			
			array('priceMin, priceMax', 'numerical', 'allowEmpty' => true),
			
			array('prices', 'pricesValidator', 'allowEmpty' => true),
		);
	}
	
	public function initialize($category_id, $descendants)
	{
		$this->_category_id = (int) $category_id;
		$this->_descendants = $descendants;
		$this->_ages = Y::db()
			->cache(1500)
			->createCommand()
			->select()
			->from(AgeRange::model()->tableName())
			->order('position ASC, id DESC')
			->queryAll();
		
		$usedBrands = Y::db()
			->cache(1700)
			->createCommand()
			->select('product_brand_id')
			->from(Product::model()->tableName())
			->where(array('in','product_category_id',array_keys($descendants)))
			->group('product_brand_id')
			->queryAll();
		
		$this->_brands = Y::db()
			->cache(1700)
			->createCommand()
			->select()
			->from(ProductBrand::model()->tableName())
			->where(array('in','brand_id',CHtml::listData($usedBrands, 'product_brand_id', 'product_brand_id')))
			->queryAll();
		
		/**
		 * @todo filter by now selected products
		 */
		$this->_prices = Y::db()
			->cache(1600)
			->createCommand()
			->select('MAX(IF(product_sell_price<>0,product_sell_price,product_price)) AS max,
 MIN(IF(product_sell_price<>0,product_sell_price,product_price)) AS min')
			->from(Product::model()->tableName())
			->where(array('in','product_category_id',array_keys($descendants)))
			->queryRow();
		
		$this->setValues();
	}
	
	private function setValues()
	{
		if(!Y::user()->hasState("AttributeSearchForm_{$this->_category_id}"))
		{
			$this->descendants = array_keys($this->_descendants);
			$this->prices = $this->_prices;
			return;
		}
		
		$this->attributes = Y::user()->getState("AttributeSearchForm_{$this->_category_id}");
		
		foreach($this->attributes as $key=>$value)
		{
			if(is_array($value))
			{
				$this->$key = $value = array_filter($value);
			}
			
			if(!$value)
			{
				$this->$key = null;
			}
		}
        if(!isset($this->prices['min']))
            $this->_prices['min'] = 0;
		if($this->prices['min'] == 0 && $this->prices['max']==1000000)
		{
			$this->prices = $this->_prices;
		}
        //Y::user()->clearStates();
	}
	
	public function rangeValidator($attribute, $params)
	{
		if($params['allowEmpty'] && !$this->$attribute)
			return;
		
		if(is_array($this->$attribute))
		{
			foreach($this->$attribute as $value)
			{
				if($value && !in_array($value, array_keys($params['range'])))
				{
					$this->addError($attribute, $params['message']);
					return;
				}
			}
		}elseif(!in_array($this->$attribute, array_keys($params['range'])))
		{
			$this->addError($attribute, $params['message']);
		}
	}
	
	public function pricesValidator($attribute, $params)
	{
		if(!$this->$attribute)
			return;
		
		if(!isset ($this->prices['min']))
		{
			$this->addError($attribute, 'Не указан нижний предел стоимости');
		}
		
		if(!isset ($this->prices['max']))
		{
			$this->addError($attribute, 'Не указан верхний предел стоимости');
		}

		if($this->prices['min'] > $this->prices['max'])
		{
			$this->addError($attribute, 'Нижний предел стоимости не может быть больше верхнего');
		}
	}

	public function attributeLabels()
	{
		return array(
			'descendants'=>'Подкатегории',
			'sex'=>'Пол',
			'ages'=>'Возвраст',
			'prices'=>'Цена',
			'brands'=>'Бренд',
			
			'priceMin'=>'',
			'priceMax'=>'',
		);
	}
	
	public function getFields()
	{
        $fields = array();
        $attributes = Category::model()->findByPk($this->_category_id)->GetAttributeSet();
        if($attributes->sex_filter != 0)
            $fields['sex'] = array(
                            'type' => 'checkboxlist',
                            'items' => $this->sexList,
                        );
        if($attributes->age_filter != 0)
            $fields['ages'] = array(
                            'type' => 'checkboxlist',
                            'items' => CHtml::listData($this->_ages, 'id', 'title'),
                        );
		return array_merge($fields, array(
			/*'descendants' => array(
				'type' => 'checkboxlist',
				'items' => $this->_descendants,
			),*/
			'<div class="filter-box">',
			'<big onclick="toggleFilterBox(this)" class="box-title">Цена <span>(в рублях)</span></big>',
			'<div class="filter-slider">',
//			'Стоимость: <span id="amount">'.intval($this->prices['min']).' - '.intval($this->prices['max']).'</span> руб',
			'<div class="slider-in">',
			'<div class="slider-values">
				<input rearonly type="text" id="filter-price-1-min" value="'.intval($this->prices['min']).'">
				&mdash;
				<input rearonly type="text" id="filter-price-1-max" value="'.intval($this->prices['max']).'">
			</div>',
			'priceMin' => array(
				'type' => 'zii.widgets.jui.CJuiSliderInput',
				'maxAttribute' => 'priceMax',
				'event' => 'stop',
				'htmlOptions' => array(
					'class'=> 'ui-slider',
				),
				'options' => array(
					'range'=>true,
					'step'=>10,
					'min' => intval($this->_prices['min']) ? intval($this->_prices['min']) - 10 : 0,
					'max' => intval($this->_prices['max']) + 10,
					'slide' => 'js:function( event, ui ) {
						$( "#filter-price-1-min" ).val( ui.values[ 0 ]);
						$( "#filter-price-1-max" ).val( ui.values[ 1 ]);
					}',
					'change' => 'js:function( event, ui ) {
						ajaxQuery($("#categoryFilter").serialize() + "&submit=1");
					}',
				),
			),
			'<span class="min">'.(intval($this->_prices['min']) ? intval($this->_prices['min']) - 10 : 0).'</span>',
			'<span class="max">'.(intval($this->_prices['max'])+10).'</span>',
			'</div>',
			'</div>',
			'</div>',
			'brands' => array(
				'type' => 'checkboxlist',
				'items' => CHtml::listData($this->_brands, 'brand_id', 'brand_title'),
			),
		));
	}
	
	public function getCriteria()
	{
		if(!$this->validate())
		{
//			$errors = $this->getErrors();
			return false;
		}
		
		$criteria = new CDbCriteria;
		
		if($this->ages)
		{
			$criteria->addInCondition('product_age_range_id', is_array($this->ages) ? $this->ages : array($this->ages));
		}
		
		if($this->sex)
		{
			$sex = is_array($this->sex) ? $this->sex : array($this->sex, 0);
			$criteria->addInCondition('product_sex', $sex);
		}

		if($this->brands)
		{
			$criteria->addInCondition('product_brand_id', is_array($this->brands) ? $this->brands : array($this->brands));
		}
		
		if($this->descendants)
		{
			$criteria->addInCondition('product_category_id', is_array($this->descendants) ? $this->descendants : array($this->descendants));
		}
		
		if($this->prices)
		{
//			$criteria->addBetweenCondition('product_price', $this->prices['min'], $this->prices['max']);
			$criteria->addCondition('(product_sell_price=0 AND (product_price BETWEEN :product_price_min AND :product_price_max)) OR (product_sell_price BETWEEN :product_price_min AND :product_price_max)');
			$criteria->params = array_merge($criteria->params, array(
				':product_price_min'=>$this->prices['min'],
				':product_price_max'=>$this->prices['max'],
			));
		}
		
		return $criteria;
	}
}
