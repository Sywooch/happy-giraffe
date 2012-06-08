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
            $p = new CHtmlPurifier();
            $p->options = array(
                'URI.AllowedSchemes'=>array(
                    'http' => true,
                    'https' => true,
                ),
                'HTML.AllowedComments' => array('more' => true),
            );
            $text = $p->purify($this->owner->$a);
            $pos = strpos($text, '<!--more-->');
            $preview = $pos === false ? $text : substr($text, 0, $pos);
            $preview = $p->purify($preview);
            $this->owner->content->preview = $preview;
            $this->owner->content->save(false);
            $this->owner->$a = $text;
		}
	}
	
	public function afterFind($event)
	{
		parent::afterFind($event);
		
		if (isset(Yii::app()->controller->route) && in_array(Yii::app()->controller->route, $this->edit_routes))
		{
			foreach ($this->attributes as $a)
			{
				$this->owner->$a = str_replace($this->hidden_html, $this->visible_html, $this->owner->$a);
			}
		}
	}
}