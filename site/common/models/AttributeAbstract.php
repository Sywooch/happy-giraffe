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
        Yii::import('attribute.models.Attribute');
        $this->_category_id = (int) $category_id;
        $category = Category::model()->findByPk($category_id);
        $attributes = AttributeSet::model()->findByPk($category->GetAttributeSet()->set_id);
        foreach($attributes->set_map as $attribute)
        {
            $model = $attribute->map_attribute;
            if($inSearch && $model->attribute_is_insearch == 0)
                continue;
            $attrs = array();
            foreach ($model->value_map as $attr_val)
                $attrs[$attr_val->map_value->value_id] = $attr_val->map_value->value_value;
            $this->_attributes['attr_' . $model->attribute_id] = array_merge(
                $model->attributes,
                array('value' => null)
            );
            if($model->attribute_type == Attribute::TYPE_ENUM)
            {
                $enums = array();
                foreach ($model->value_map as $attr_val)
                    $enums[$attr_val->map_value->value_id] = $attr_val->map_value->value_value;
                $this->_enum[$model->attribute_id] = $enums;
            }
        }

        if($inSearch)
            $this->setSearchValues();
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

    public function selected($attr)
    {
        $this->setSearchValues();
        if(!isset($this->_searchAttributes[$attr]))
            return array();
        $keys = array();
        foreach($this->_searchAttributes[$attr] as $value)
        {
            if($value == '' || $value == 0)
                continue;
            $keys[] = $value;
        }
        return $keys;
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
						'type'=>'checkboxlist',
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
	
	public function getFilter()
	{
		$this->setSearchValues();
		
		$eav = $text_eav = array('and');
		$is_eav = $is_text_eav = false;

        $criteria = new CDbCriteria();
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
                    if($this->_attributes[$key]['attribute_type'] != Attribute::TYPE_ENUM)
                    {
                        $criteria->addCondition("(eav_attribute_id=:{$key}_id AND eav_attribute_value=:{$key}_value)");
                        $criteria->params[":{$key}_id"] = end($id);
                        $criteria->params[":{$key}_value"] = $value;
                    }
                    else
                    {
                        $ids = array();
                        foreach($value as $val)
                        {
                            if($val == '' || $val == 0)
                                continue;
                            $ids[] = $val;
                        }
                        if(count($ids) == 0)
                            break;
                        $criteria->addCondition('(eav_attribute_id = ' . end($id) . ' and eav_attribute_value in ('.implode(',', $ids).'))', 'or');
                    }
                    $eav[] = true;
                    $is_eav = true;
                    break;
                default:
                    break;
            }
        }

		if(count($eav)==1 && count($text_eav)==1)
			return false;
		
		$eav_count = count($eav)-1;
		$text_eav_count = count($text_eav)-1;
		
		$eav_ids = $text_eav_ids = array();
		
		if($eav_count)
		{
            $criteria->select = "eav_product_id, count(DISTINCT eav_attribute_id) N";
            $criteria->group = 'eav_product_id';
            $criteria->having = "N=$eav_count";
            $eav_ids = ShopProductEav::model()->findAll($criteria);
			$eav_ids = CHtml::listData($eav_ids, 'eav_product_id', 'eav_product_id');
		}
		
		if($text_eav_count)
		{
			$text_eav_ids = Y::command()
				->select("eav_product_id, count(DISTINCT eav_attribute_id) N")
				->from('shop__product_eav_text')
				->where($text_eav, $text_where)
				->group('eav_product_id')
				->having("N=$text_eav_count")
				->queryAll();
			$text_eav_ids = CHtml::listData($text_eav_ids, 'eav_product_id', 'eav_product_id');
		}
		
		if(!$is_eav)
			return $text_eav_ids;
			
		if(!$is_text_eav)
			return $eav_ids;
		
		
		return array_intersect($eav_ids, $text_eav_ids);
	}
}