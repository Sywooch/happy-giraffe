<?php

class DateWidget extends CWidget
{
	public $model;
	public $attribute;
	
	private $_d = array();
	private $_m = array();
	private $_y = array();
	
	private $_current;
	
	public function init()
	{
		for($i = 1; $i <= 31; $i++)
		{
			$this->_d[sprintf("%02d", $i)] = $i;
		}
		
		$current_year = date('Y');
		for ($i = $current_year; $i >= $current_year - 100; $i--)
		{
			$this->_y[$i] = $i;
		}
		
		$this->_m = array(
			'01' => 'января',
			'02' => 'февраля',
			'03' => 'марта',
			'04' => 'апреля',
			'05' => 'мая',
			'06' => 'июня',
			'07' => 'июля',
			'08' => 'августа',
			'09' => 'сентября',
			'10' => 'октября',
			'11' => 'ноября',
			'12' => 'декабря',
		);
		
		if ($this->model->{$this->attribute} !== null)
		{
			$pieces = explode('-', $this->model->{$this->attribute});
            if(count($pieces) != 3)
                $this->_current = null;
            else
                $this->_current = array(
                    'd' => $pieces[2],
                    'm' => $pieces[1],
                    'y' => $pieces[0],
                );
		}
		else
		{
			$this->_current = array(
				'd' => '',
				'm' => '',
				'y' => '',
			);
		}
	}
	
	public function run()
	{
		echo CHtml::dropDownList(CHtml::activeId($this->model, $this->attribute . '_d'), $this->_current['d'], $this->_d, array(
			'prompt' => '-',
            'class' => 'chzn',
		)).'&nbsp;&nbsp;';
		echo CHtml::dropDownList(CHtml::activeId($this->model, $this->attribute . '_m'), $this->_current['m'], $this->_m, array(
			'prompt' => '-',
            'class' => 'chzn',
		)).'&nbsp;&nbsp;';
		echo CHtml::dropDownList(CHtml::activeId($this->model, $this->attribute . '_y'), $this->_current['y'], $this->_y, array(
			'prompt' => '-',
            'class' => 'chzn',
		));
		echo CHtml::activeHiddenField($this->model, $this->attribute);
		
		$cs = Yii::app()->clientScript;
		
		$js = "
			var el = $('#" . CHtml::activeId($this->model, $this->attribute) . "');
			var d = '#" . CHtml::activeId($this->model, $this->attribute . '_d') . "';
			var m = '#" . CHtml::activeId($this->model, $this->attribute . '_m') . "';
			var y = '#" . CHtml::activeId($this->model, $this->attribute . '_y') . "';

			$(d+', '+m+', '+y).change(function ()
			{
				if ($(d).val() != '' && $(m).val() != '' && $(y).val() != '')
				{
					el.val($(y).val() + '-' + $(m).val() + '-' + $(d).val());
				}
			});	
		";
		
		$cs
			->registerScript(CHtml::activeId($this->model, $this->attribute) . '_dateWidget', $js);
	}
}