<?php $form=$this->beginWidget('CActiveForm', array()); ?>
<?php echo CHtml::hiddenField('OrderId', $OrderId);?>
ЗАКАЗ № <?php echo $OrderId;?><br></br>
<?php echo "Вы выбрали город: ".$modelCities->name;?>
<br></br>

Мы сотрудничаем с разными службами доставки.
Доставка возможна в следующие города:

<table class="items">
<thead>
<tr>

<th id="product-grid_c0">id</th><th id="product-grid_c1">name</th><th id="product-grid_c2">destination</th><th id="product-grid_c3">price</th><th class="button-column" id="product-grid_c4">Действия</th></tr>
</thead>
<tbody>

<?php 
$this->widget('zii.widgets.CListView', array(
  'dataProvider' => $dataProvider,
  'itemView' => '_listTable',
  'template' => "{items}",
  'tagName' => 'div',
  'emptyText' => '',
  'viewData' => array('OrderId'=>$OrderId),
	'itemsTagName'=>'div',
	'itemsCssClass'=>'foto_nev',
));
?>
</tbody>
</table>
<?php $this->endWidget(); ?>