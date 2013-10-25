<?php
	$cs = Yii::app()->clientScript;

	$js = "
		$('form').submit(function(e) {
			e.preventDefault();
			$.ajax({
				type: 'POST',
				url: '" . $this->createUrl('fixSave') . "',
				data: $(this).serialize(),
				success: function() {
					$(this).parents('tr').remove();
				},
				context: this,
			});
		});
	";
	
	$cs
		->registerScript('fixList', $js);
?>
<table>
	<tr>
		<td>Тема</td>
		<td>Новый автор</td>
	</tr>
	<?php foreach ($contents as $c): ?>
		<tr>
			<td>
				<?php echo CHtml::link($c->title, $this->createUrl('view', array(
					'community_id' => $c->rubric->community->id,
					'content_type_slug' => $c->type->slug,
					'content_id' => $c->id,
				))); ?>
			</td>
			<td>
				<?php $form = $this->beginWidget('CActiveForm'); ?>
				<?php
					$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
						'name' => 'email[' . $c->id . ']',
	
						'sourceUrl' => $this->createUrl('community/fixUsers'),
			
						'options' => array(
							'select' => "js:function (event, ui)
								{
									$(this).next().val(ui.item.id);
									$.ajax({
										type: 'POST',
										url: '" . $this->createUrl('fixUser') . "',
										data: {
											author_id: ui.item.id
										},
										success: function(response) {
											$(this).parents('td').find('div.user').html(response);
										},
										context: this
									});
								}
							",
						),
						
						'htmlOptions' => array(
							'style' => 'border: #000 1px solid;',
						),
					));
				?>
				<?php echo $form->hiddenField($c, 'author_id', array('name' => 'author_id')); ?>
				<?php echo CHtml::hiddenField('content_id', $c->id); ?>
				<?php echo CHtml::submitButton('Сохранить'); ?>
				<?php $this->endWidget(); ?>
				<div class="user">
				
				</div>
				<div class="clear"> </div>
			</td>
		</tr>
	<?php endforeach; ?>
</table>