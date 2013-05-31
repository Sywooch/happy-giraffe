<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-city-form',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
	));
?>

<?php echo CHtml::hiddenField('OrderId', $OrderId);?>
<?php echo $form->label($modelRegions, 'name'); ?>
<br></br>
<?php
echo $form->dropDownList(
	$modelRegions, 'id', $modelRegions->getRegions(), 
	array(
	    'empty' => array('0' => '...'),
	    'id'=>'selreg'
	 )
	);
?>
<br></br>
<?php
echo $form->dropDownList(
	$modelDistrict, 'id', 
	(isset($modelRegions->id))?$modelDistrict->getDistrict($modelRegions->id):$modelDistrict->getDistrict(),
	array(
	    'empty' => array('0' => '...'),
	    'id'=>'seldist'
	 )
	);
?>
<br></br>
<?php echo $form->dropDownList(
	$modelCities, 'id', (isset($modelCities->id))
		?$modelCities->getCity()
		:$modelCities->getCities($modelRegions->id, $modelDistrict->id), 
	array(
	    'ajax' => array(
			'type' => 'POST',
			'data' => 'js:({
				city_id : this.value, 
				region_id: $("#selreg").val(), 
				district_id: $("#seldist").val(), 
				OrderId: $("#OrderId").val()
			})',
			'dataType' => 'html',
			'url' => $this->createUrl('/delivery/default/showDeliveryTable'),
			'success' => 'function(data){
				$("#table").html(data);
				$("#table_dop").html("");
			}',
	    ),
	    'id' => 'selcity')); ?>
<?php 
$js = '
$(".noBTC").live("click", function() {
	$("#table_dop").html("");
});
$(".BTC").live("click", function() {
	//Здесь запускаем ajax ссылку и выводим данные в table_dop
	$.ajax({
		url:$(this).attr("rel"),
		type: "POST",
		dataType: "json",
		success: function(data){
			if(data.method == "show")
			{
				$("#table_dop").html(data.html);
				$("#totalPrice").html(data.price + toal_price);
				return false;
			}
		}
	});
});

$("#settings-sel").live("submit", function(){	    
    $.ajax({
	url:$(this).attr("action"),
	type: "POST",
	dataType: "json",
	data: $("#settings-sel").serialize(),
	success: function(data){
		if(data.method == "show")
		{
			$("#table_dop").html(data.html);
			return false;
		}
		if(data.method == "redir")
		{
			windows.location = data.url;
		}
	},
	complete: function(msg, txt){
	    return false;
	},
    });
    return false;
})
';

Y::script()->registerScript("BTC_script", $js);
$js = '$(document).ready(function(){
$.ajax({
	url:"'.$this->createUrl('/delivery/default/showDeliveryTable').'",
	type: "POST",
	data: ({
	    city_id : $("#selcity").val(), 
	    region_id: $("#selreg").val(), 
	    district_id: $("#seldist").val(), 
	    OrderId: $("#OrderId").val()
	    }),
	success: function(data){
	    $("#table").html(data);
	}
});
return false;
})';

Y::script()->registerScript("BTC2_script", $js);
Yii::app()->clientScript->registerCoreScript('yiiactiveform');
?>
<?php $this->endWidget(); ?>
<?php  /*Место куда будет выводиться табличка с данными по доставке в города*/?>
<div id="table"></div>
<?php  /*Место куда будет выводиться дополнительные параметры настройки доставки*/?>
<div id="table_dop"></div>
<div id="table3"></div>