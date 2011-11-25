<?php $form=$this->beginWidget('CActiveForm',	
	array(
//	'id' => 'show-deliveries-form',
//	'action'=>Yii::app()->createUrl($this->route),
//	'method'=>'post',
)); ?>
<?php echo CHtml::hiddenField('OrderId', $OrderId);?>
ЗАКАЗ № <?php echo $OrderId;?><br></br>
<?php echo "Вы выбрали город: ".$modelCities->name;?>
<br></br>

Мы сотрудничаем с разными службами доставки.
Доставка возможна в следующие города:

<?php 
/*
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$dataProvider,
//	'filter'=>$model,
//	'template'=>'{items}',
	'selectableRows'=>NULL,
	'columns'=>array(
	    'id',
	    'name',
	    'destination',
	    'price',
//		array(
//		    'name'=>'select',
//		    'class'=>'CCheckBoxColumn',
//		    'header'=>'Показывать',
//		),
		
		array(
		    'class'=>'CButtonColumn',
		    'header'=>'Действия',
		    'htmlOptions'=>array('style'=>'width:100px;'),
		    'template'=>'{select}',
		    'buttons'=>array(
			'select'=>array(
			    //добавить проверку на пикпоинт и если пикпоинт то выводить аяксом форму пикпоинта
			    'url'=>'array("/delivery/default/selectDeliveryModule", "OrderId"=>'.$OrderId.', "name"=>$data["id"], "city"=>$data["destination"])',
			    'options'=>array("class"=>"BTC", 'title'=>$data['htmlclass']),
			    ),
		    )
		),
	),
));
 
 */
?>
<table class="items">
<thead>
<tr>

<th id="product-grid_c0">id</th><th id="product-grid_c1">name</th><th id="product-grid_c2">destination</th><th id="product-grid_c3">price</th><th class="button-column" id="product-grid_c4">Действия</th></tr>
</thead>
<tbody>

<?php 
		  $this->widget('zii.widgets.CListView', array(
			  'dataProvider'=> $dataProvider,
			  'itemView'=>'_listTable',
			  'template'=>"{items}",
			  'tagName'=>'div',
			  'emptyText'=>'',
			  'viewData'=>array('OrderId'=>$OrderId),
			    'itemsTagName'=>'div',
			    'itemsCssClass'=>'foto_nev',
		  ));

?>
</tbody>
</table>


<?php $this->endWidget(); ?>
<?php
/*$this->widget('ext.fancybox.EFancyBox', array(
        'target'=>'.BTC',
        )
);/**/
?>