<?php
$form = $this->beginWidget('CActiveForm', array( 'id' => 'search-friends-form')); ?>
<table  style="width:300px;margin-top:50px;color:black !important;">
	<tr>
	    <td  class="centr_tabl2"><?php echo $form->labelEx($model, 'delivery_name');?></td>
	    <td class="centr_tabl3">
			<?php echo $form->dropDownList($model, 'delivery_name', $modules); ?>
	    </td>
	</tr>	
	
<?php echo CHtml::submitButton('Add');?>
	
<?php $this->endWidget(); ?>
	
<?php
$this->widget('zii.widgets.grid.CGridView', array(
	'id' => 'articles-grid',
	'dataProvider' => $dataProvider,
	'columns' => array(
		'delivery_name',
		array(
			'class' => 'CButtonColumn',
			'buttons' => array(
					'install' => array(
						'label' => 'Install',
						'visible' => '($data->delivery_is_install == 0)?true:false',
						'url' => 'Yii::app()->createUrl("delivery/$data->delivery_name/default/install")',
					),
					'uninstall' => array(
						'label' => 'Uninstall',
						'visible' => '($data->delivery_is_install == 1)?true:false',
						'url' => 'Yii::app()->createUrl("delivery/uninstall", array("id"=>$data->id))',
					),
			 ),
			 'template' => '{install} {uninstall}',
		),
	),
));
?>

