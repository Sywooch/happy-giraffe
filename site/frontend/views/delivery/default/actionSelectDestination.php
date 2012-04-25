<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'search-city-form',
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'post',
	));
?>

<?php echo CHtml::hiddenField('OrderId', $OrderId);?>
<?php echo $form->label($modelRegions, 'name'); ?>
<br/>
<?php
echo $form->dropDownList(
	$modelRegions, 'id', $modelRegions->getRegions(), 
	array(
	    'empty' => array('0' => '...'),
	    'ajax' => array(
		'type' => 'POST',
		'data' => 'js:({regval : this.value})',
		'dataType' => 'json',
		'url' => $this->createUrl('/delivery/default/getDistrictNames'),
		'success' => 'function(msg){
			if(msg.data!="empty"){
				$("#seldist").html(msg.data);
				$("#selcity").html("");
			} else {
			    $("#seldist").html("");
			    $("#selcity").html("");
			};
		}',
	    ),
	    'id'=>'selreg'
	 )
	);
?>
<br/>
<?php
echo $form->dropDownList(
	$modelDistrict, 'id', 
	(isset($modelRegions->id))?$modelDistrict->getDistrict($modelRegions->id):$modelDistrict->getDistrict(),
	array(
	    'empty' => array('0' => '...'),
	    'ajax' => array(
		'type' => 'POST',
		'data' => 'js:({regval : this.value})',
		'dataType' => 'json',
		'url' => $this->createUrl('/delivery/default/getCityNames'),
		'success' => 'function(msg){
			if(msg.data!="empty"){
				$("#selcity").html(msg.data);
			};
		}',
	    ),
	    'id'=>'seldist'
	 )
	);
?>
<br/>
<?php echo $form->dropDownList(
	$modelCities, 'id', (isset($modelCities->id))
		?$modelCities->getCity()
		:$modelCities->getCities($modelRegions->id, $modelDistrict->id), 
	array(
//	    'onChange'=>'js:citySelA(this)',
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
//			alert(data);
			$("#table").html(data);
//			if(msg.data!="empty"){
//				$("#table").html(msg.data);
//			};
		}',
	    ),
	    'id' => 'selcity')); ?>
<?php 
//echo CHtml::ajaxSubmitButton('D', array('/delivery/default/showDeliveryTable'),array(
//    'update'=>'#table'
//));
//echo CHtml::linkButton('D', array('/delivery/default/showDeliveryTable')); 
/**/
/*
$js = 'function citySelA(sel){
//alert($(sel).val());
$.ajax({
		type: "POST",
		data :({
		    city_id : $(sel).val(), 
		    region_id: $("#selreg").val(), 
		    district_id: $("#seldist").val(), 
		    OrderId: $("#OrderId").val()
		    }),
		dataType :"html",
		url :"'. $this->createUrl('/delivery/default/showDeliveryTable').'",
		success: function(msg){
			alert(msg);
			$("#table").html(msg);
		},
		complete: function(msg, txt){
			alert(txt);
		},
})}';

Y::script()->registerScript('bmmbmbmbn', $js, CClientScript::POS_HEAD);
*/
$js = '$(".BTC").live("click", function() {
//Здесь запускаем ajax ссылку и выводим данные в table_dop
$.ajax({
	url:$(this).attr("href"),
	type: "POST",
	dataType: "html",
	success: function(data){
	    $("#table_dop").html(data);
		return false;
	}
});
return false;
});

$("#settings-sel").live("submit", function(){	    
    $.ajax({
	url:$(this).attr("action"),
	type: "POST",
	dataType: "html",
	data: $("#settings-sel").serialize() + "&vdv=sdsd",
	success: function(data){
//	    alert(data);
	    $("#table_dop").html(data);
	    return false;
	},
	complete: function(msg, txt){
//	    alert(txt);
	    return false;
	},
    });
    return false;
})

';

Y::script()->registerScript("BTC_script", $js);
/**/
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
/*
$js = '$("#settings-sel").yiiactiveform({
    "validateOnSubmit":true,
    "validationUrl":"/delivery/default/validateDeliveryModule",
    "attributes":[
	{
	    "id":"EExpressDPM_price",
	    "inputID":"EExpressDPM_price",
	    "errorID":"EExpressDPM_price_em_",
	    "model":"EExpressDPM",
	    "name":"price",
	    "enableAjaxValidation":true
	},
	{
	    "id":"EExpressDPM_address",
	    "inputID":"EExpressDPM_address",
	    "errorID":"EExpressDPM_address_em_",
	    "model":"EExpressDPM",
	    "name":"address",
	    "enableAjaxValidation":true
	 }
	 ]
	 });
 ';

Y::script()->registerScript("BTC3_script", $js);
*/
Yii::app()->clientScript->registerCoreScript('yiiactiveform');
/**/
?>
<?php $this->endWidget(); ?>

<?php
/*$this->widget('ext.fancybox.EFancyBox', array(
        'target'=>'.BTC',
        )
);/**/
?>

<?php  /*Место куда будет выводиться табличка с данными по доставке в города*/?>
<div id="table"></div>

<?php  /*Место куда будет выводиться дополнительные параметры настройки доставки*/?>
<div id="table_dop"></div>

<div id="table3"></div>