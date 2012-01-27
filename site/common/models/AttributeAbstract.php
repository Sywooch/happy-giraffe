<?php

/**
 * Description of AttributeAbstract
 *
 * @author Вячеслав
 */
class AttributeAbstract extends CFormModel
{

	protected $_attributes = array();
	
	protected $_enum = array();
	
	protected $_category_id;
	
	protected $_product_id;
	
	protected $_searchAttributes = array();

	public function initialize($category_id, $inSearch=false)
	{
		$this->_category_id = (int) $category_id;
		
		$condition = 'map_category_id=:map_category_id';
		$where = array(
			':map_category_id' => $this->_category_id,
		);
		
		if($inSearch)
		{
			$condition .= ' AND map_in_search=:map_in_search';
			$where[':map_in_search'] = 1;
		}
		
		$attributes = Y::command()
			->select()
			->from('shop_category_attributes_map')
			->leftJoin('shop_product_attribute', 'map_attribute_id=attribute_id')
			->where($condition, $where)
			->queryAll();

		foreach($attributes as $attribute)
		{
			$this->_attributes["attr_{$attribute['attribute_id']}"] = array_merge(
				$attribute,
				array('value' => null)
			);
		}
		
		Yii::import('attribute.models.Attribute');
		
		foreach($this->_attributes as $attribute)
		{
			if($attribute['attribute_type'] == Attribute::TYPE_ENUM)
			{
				$this->_enum[] = $attribute['attribute_id'];
			}
		}
		if($this->_enum)
		{
			$this->_enum = Y::command()
				->select('map_attribute_id, value_id, value_value')
				->from('shop_product_attribute_value_map')
				->leftJoin('shop_product_attribute_value', 'map_value_id=value_id')
				->where(array('in', 'map_attribute_id', $this->_enum))
				->order('value_id')
				->queryAll();

			$this->_enum = CHtml::listData($this->_enum, 'value_id', 'value_value', 'map_attribute_id');
		}
		
		if($inSearch)
			$this->setSearchValues();
	}

	public function setProductValues($product_id)
	{
		$this->_product_id = $product_id;
		
		$attribute_eav_values = Y::command()
			->select('eav_attribute_id, eav_attribute_value')
			->from('shop_product_eav')
			->where('eav_product_id=:eav_product_id', array(
				':eav_product_id' => $product_id,
			))
			->queryAll();

		$attribute_eav_text_values = Y::command()
			->select('eav_attribute_id, eav_attribute_value')
			->from('shop_product_eav_text')
			->where('eav_product_id=:eav_product_id', array(
				':eav_product_id' => $product_id,
			))
			->queryAll();

		$attribute_eav_values = CHtml::listData($attribute_eav_values, 'eav_attribute_id', 'eav_attribute_value');
		$attribute_eav_text_values = CHtml::listData($attribute_eav_text_values, 'eav_attribute_id', 'eav_attribute_value');
		
		$attribute_values = $attribute_eav_values + $attribute_eav_text_values;
		
		foreach($this->_attributes as $key=>$attribute)
		{
			if(isset($attribute_values[$attribute['attribute_id']]))
				$this->_attributes[$key]['value'] = $attribute_values[$attribute['attribute_id']];
		}
	}
	
	private function setSearchValues()
	{
		if(!Y::user()->hasState("AttributeAbstract_{$this->_category_id}"))
			return;
		
		$this->_searchAttributes = Y::user()->getState("AttributeAbstract_{$this->_category_id}");
		
		foreach($this->_attributes as $key=>$attribute)
		{
			if(isset($this->_searchAttributes[$key]))
				$this->_attributes[$key]['value'] = $this->_searchAttributes[$key];
		}
	}

	public function __get($name)
	{
		if(isset($this->_attributes[$name]))
			return $this->_attributes[$name]['value'];

		return parent::__get($name);
	}

	public function __set($name, $value)
	{
		$this->_attributes[$name]['value'] = $value;
	}

	public function rules()
	{
		Yii::import('attribute.models.Attribute');

		$rule = array();
		foreach($this->_attributes as $key=>$attribute)
		{
			switch($attribute['attribute_type'])
			{
				case Attribute::TYPE_TEXT:
					$rule[] = array($key, 'safe');
					break;
				case Attribute::TYPE_INTG:
					$rule[] = array($key, 'numerical', 'integerOnly'=>true, 'allowEmpty'=>true);
					break;
				case Attribute::TYPE_BOOL:
					break;
				case Attribute::TYPE_ENUM:
					$rule[] = array($key, 'in', 'range'=>  array_keys($this->_enum[$attribute['attribute_id']]), 'allowEmpty'=>true);
					break;
				default:
					new Exception("Error rule for attribute {$key} - {$attribute['attribute_title']}");
					break;
			}
		}
		return $rule;
	}
	
	public function attributeLabels()
	{
		$label = array();
		foreach($this->_attributes as $key=>$attribute)
		{
			$label[$key] = $attribute['attribute_title'];
		}
		return $label;
	}
	
	public function getFields()
	{
		Yii::import('attribute.models.Attribute');
		
		$elements = array();
		foreach($this->_attributes as $key=>$attribute)
		{
			switch($attribute['attribute_type'])
			{
				case Attribute::TYPE_ENUM:
					$elements[$key] = array(
						'type'=>'dropdownlist',
						'items'=>$this->_enum[$attribute['attribute_id']]
							? $this->_enum[$attribute['attribute_id']]
							: array(),
						'empty'=>'---',
					);
					break;
				case Attribute::TYPE_TEXT:
					$elements[$key] = array(
						'type'=>'textarea',
					);
					break;
				case Attribute::TYPE_BOOL:
					$elements[$key] = array(
						'type'=>'checkbox',
					);
					break;
				case Attribute::TYPE_INTG:
					$elements[$key] = array(
						'type'=>'text',
					);
					break;
					break;
				default:
					new Exception("Error field for attribute {$key} - {$attribute['attribute_title']}");
					break;
			}
		}
		
		return $elements;
	}
	
	public function getSearchFields()
	{
		Yii::import('attribute.models.Attribute');
		
		$elements = array();
		foreach($this->_attributes as $key=>$attribute)
		{
			switch($attribute['attribute_type'])
			{
				case Attribute::TYPE_ENUM:
					$elements[$key] = array(
						'type'=>'dropdownlist',
						'items'=>$this->_enum[$attribute['attribute_id']]
							? $this->_enum[$attribute['attribute_id']]
							: array(),
						'empty'=>'---',
					);
					break;
				case Attribute::TYPE_BOOL:
					$elements[$key] = array(
						'type'=>'radiolist',
						'items'=>array(
							0=>'Нет',
							1=>'Да',
						),
					);
					break;
				case Attribute::TYPE_TEXT:
				case Attribute::TYPE_INTG:
					$elements[$key] = array(
						'type'=>'text',
					);
					break;
					break;
				default:
					new Exception("Error field for attribute {$key} - {$attribute['attribute_title']}");
					break;
			}
		}
		
		return $elements;
	}
	
	public function getForm()
	{
		$elements = array(
			'title' => 'Атрибуты',
			'elements' => $this->getFields(),
			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'label' => 'Сохранить',
				),
			),
		);
		
		return new CForm($elements, $this);
	}
	
	public function getSearchForm()
	{
		$elements = array(
			'title' => 'Фильтр',
			'elements' => $this->getSearchFields(),
			'method' => 'post',
			'buttons' => array(
				'submit' => array(
					'type' => 'submit',
					'label' => 'Поиск',
				),
			),
		);
		
		return new CForm($elements, $this);
	}
	
	public function save($validate=true)
	{
		if($validate && !$this->validate())
			return false;
		
		$eav = $text_eav = array();
		foreach($this->_attributes as $key=>$attribute)
		{
			switch($attribute['attribute_type'])
			{
				case Attribute::TYPE_TEXT:
					$text_eav[$key] = $attribute;
					$text_eav[$key]['_value'] = $text_eav[$key]['value'];
					break;
				case Attribute::TYPE_BOOL:
				case Attribute::TYPE_ENUM:
				case Attribute::TYPE_INTG:
					$eav[$key] = $attribute;
					$eav[$key]['_value'] = intval($eav[$key]['value']);
					break;
				default:
					new Exception("Error field for attribute {$key} - {$attribute['attribute_title']}");
					break;
			}
		}
		
		foreach($text_eav as $attribute)
		{
			$eav_id = Y::command()
				->select('eav_id')
				->from('shop_product_eav_text')
				->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
					':eav_product_id'=>$this->_product_id,
					':eav_attribute_id'=>$attribute['attribute_id'],
				))
				->limit(1)
				->queryScalar();
			
			if($eav_id)
			{
				Y::command()
					->update('shop_product_eav_text', array(
						'eav_attribute_value'=>$attribute['_value'],
					), 'eav_id=:eav_id', array(
						':eav_id'=>$eav_id,
					));
			}
			else
			{
				Y::command()
					->insert('shop_product_eav_text', array(
						'eav_product_id'=>$this->_product_id,
						'eav_attribute_id'=>$attribute['attribute_id'],
						'eav_attribute_value'=>$attribute['_value'],
					));
			}
		}
		
		foreach($eav as $attribute)
		{
			$eav_id = Y::command()
				->select('eav_id')
				->from('shop_product_eav')
				->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
					':eav_product_id'=>$this->_product_id,
					':eav_attribute_id'=>$attribute['attribute_id'],
				))
				->limit(1)
				->queryScalar();
			
			if($eav_id)
			{
				Y::command()
					->update('shop_product_eav', array(
						'eav_attribute_value'=>$attribute['_value'],
					), 'eav_id=:eav_id', array(
						':eav_id'=>$eav_id,
					));
			}
			else
			{
				Y::command()
					->insert('shop_product_eav', array(
						'eav_product_id'=>$this->_product_id,
						'eav_attribute_id'=>$attribute['attribute_id'],
						'eav_attribute_value'=>$attribute['_value'],
					));
			}
		}
		
		return true;
	}
	
	public function getFilter()
	{
		$this->setSearchValues();
		
		$eav = $text_eav = array('and');
		$where = $text_where = array();
		$is_eav = $is_text_eav = false;
		foreach($this->_searchAttributes as $key=>$value)
		{
			if(!$value || !isset($this->_attributes[$key]))
				continue;
			
			switch($this->_attributes[$key]['attribute_type'])
			{
				case Attribute::TYPE_TEXT:
					$text_eav[] = "(eav_attribute_id=:{$key}_id AND eav_attribute_value LIKE :{$key}_value)";
					$text_where[":{$key}_id"] = end(explode('_', $key, 2));
					$text_where[":{$key}_value"] = "%$value%";
					$is_text_eav = true;
					break;
				case Attribute::TYPE_BOOL:
				case Attribute::TYPE_ENUM:
				case Attribute::TYPE_INTG:
                    $id = explode('_', $key, 2);
					$eav[] = "(eav_attribute_id=:{$key}_id AND eav_attribute_value=:{$key}_value)";
					$where[":{$key}_id"] = end($id);
					$where[":{$key}_value"] = $value;
					$is_eav = true;
					break;
				default:
					new Exception("Error field for attribute {$key} - {$attribute['attribute_title']}");
					break;
			}
		}
		
		if(count($eav)==1 && count($text_eav)==1)
			return false;
		
		$eav_count = count($eav)-1;
		$text_eav_count = count($text_eav)-1;
		
//		SELECT p_id, count(distinct a_id) N
//FROM `product_attribute_map` 
//WHERE (a_id=1 AND a_v=1) OR (a_id=2 AND a_v=2) OR (a_id=3 AND a_v>=1 AND a_v<=4)
//GROUP BY `p_id`
//HAVING N=3;
		
		$eav_ids = $text_eav_ids = array();
		
		if($eav_count)
		{
			$eav_ids = Y::command()
				->select("eav_product_id, count(DISTINCT eav_attribute_id) N")
				->from('shop_product_eav')
				->where($eav, $where)
				->group('eav_product_id')
				->having("N=$eav_count")
				->queryAll();
			$eav_ids = CHtml::listData($eav_ids, 'eav_product_id', 'eav_product_id');
		}
		
		if($text_eav_count)
		{
			$text_eav_ids = Y::command()
				->select("eav_product_id, count(DISTINCT eav_attribute_id) N")
				->from('shop_product_eav_text')
				->where($text_eav, $text_where)
				->group('eav_product_id')
				->having("N=$text_eav_count")
				->queryAll();
			$text_eav_ids = CHtml::listData($text_eav_ids, 'eav_product_id', 'eav_product_id');
		}
		
//		Y::dump($eav_ids, false);
//		Y::dump($text_eav_ids);
		
		if(!$is_eav)
			return $text_eav_ids;
			
		if(!$is_text_eav)
			return $eav_ids;
		
		
		return array_intersect($eav_ids, $text_eav_ids);
	}

}