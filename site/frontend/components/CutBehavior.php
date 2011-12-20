<?php

class CutBehavior extends CActiveRecordBehavior
{
	public $attributes = array();
	public $edit_routes = array();
	public $visible_html = '<hr class="cuttable" />';
	public $hidden_html = '<!--more-->';
	
	public function beforeSave($event)
	{
		parent::beforeSave($event);
		
		foreach ($this->attributes as $a)
		{
			$this->owner->$a = str_replace($this->visible_html, $this->hidden_html, $this->owner->$a);
		}
	}
	
	public function afterFind($event)
	{
		parent::afterFind($event);
		
		if (in_array(Yii::app()->controller->route, $this->edit_routes))
		{
			foreach ($this->attributes as $a)
			{
				$this->owner->$a = str_replace($this->hidden_html, $this->visible_html, $this->owner->$a);
			}
		}
	}
}