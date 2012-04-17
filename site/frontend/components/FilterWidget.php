<?php

/**
 * Description of FilterWidget
 *
 * @author Вячеслав
 */
class FilterWidget extends CWidget
{
	public $category_id;
	
	public $descendants;

	public function run()
	{
        $attributes = new AttributeAbstract;
        $attributes->initialize($this->category_id, true);

		$filter = new AttributeSearchForm;
		$filter->initialize($this->category_id, $this->descendants);
		$elements = array(
			'attributes' => array(
				'id' => 'categoryFilter',
				'name' => 'categoryFilter',
			),
			'elements' => array(
				'attributes' => array(
					'inputElementClass' => 'JFormInputElement',
					'type' => 'form',
					'elements' => $attributes->getSearchFields(),
				),
				'filter' => array(
					'inputElementClass' => 'JFormInputElement',
					'type' => 'form',
					'elements' => $filter->getFields(),
				),
			),
			'method' => 'post',
			'buttons' => array(
//				'submit' => array(
//					'type' => 'submit',
//					'label' => 'Поиск',
//				),
				'<div class="filter-box" style="text-align: center;">',
				'resetFilter' => array(
					'type' => 'submit',
					'type' => 'image',
					'src' => '/images/reset-filter.png',
					'label' => 'Очистить',
				),
				'</div>',
			),
		);
		
		$form = new CForm($elements);
		$form['attributes']->model = $attributes;
		$form['filter']->model = $filter;
		
		echo $form;
		
		$this->registerScript();
	}
	
	protected function registerScript()
	{
		$script = '
		$("#categoryFilter").mouseenter(function(){
			isInForm = true;
		}).mouseleave(function(){
			isInForm = false;
			if(tryAjax)
			{
				clearTimeout(deltime);
				submitForm();
				tryAjax = false;
			}
		});
		';
		
		Y::script()->registerScript(__CLASS__, $script);
		
		$js = '
			
var isInForm = false;
var interval = 1500;
var oldData;
var deltime = setTimeout(function(){}, interval);
var tryAjax = false;

function ajaxQuery(data)
{
	clearTimeout(deltime);
	
	if(data == oldData)
	{
		return;
	}
	oldData = data;
	
	tryAjax = true;
	deltime = setTimeout(function(){
		tryAjax = false;
		submitForm();
	}, interval);
}

function submitForm()
{
    $("#categoryContent").css({opacity:1}).animate({opacity:0}, 300);
'.
	CHtml::ajax(array(
		'url' => '',
        'success' => 'js:function(data) {
            $("#categoryContent").stop().css({opacity:0}).html(data).animate({opacity:1}, 300);
        }',
		'type' => 'post',
		'data' => 'js:oldData',
	))
.'
}

function setItemRadiogroup(el, val){
	var rg = $(el).parents(".filter-radiogroup");
	var li = $(el).parent();
	
	if (!li.hasClass("active")){
		if (!rg.hasClass("filter-radiogroup-multiply"))
		{
			rg.find("li").removeClass("active");
			rg.find("input").val(val);
		} else {
			li.find("input").val(val);
		}
		
		li.addClass("active");
		ajaxQuery($("#categoryFilter").serialize() + "&submit=1");
	}
}

function unsetItemRadiogroup(el){
	var rg = $(el).parents(".filter-radiogroup");
	var li = $(el).parent();
	
	$(li).removeClass("active");
	$(li).find("input").val(0);
	ajaxQuery($("#categoryFilter").serialize() + "&submit=1");
}';
		Y::script()->registerScript(__CLASS__.'common', $js, CClientScript::POS_BEGIN);
	}

}