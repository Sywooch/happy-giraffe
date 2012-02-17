<?php
	$cs = Yii::app()->clientScript;
	$js = "
$('button.cancel').live('click', function(e) {
	e.preventDefault();
	var editor = CKEDITOR.instances['Comment[text]'];
    editor.setData('');
});
$('#add_comment').live('submit', function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		data: $(this).serialize(),
		dataType: 'json',
		url: " . CJSON::encode(Yii::app()->createUrl('ajax/sendcomment')) . ",
		success: function(response) {
			if (response.status == 'ok')
			{
				$.ajax({
					type: 'POST',
					data: {
						model: $('#Comment_model').val(),
						object_id: $('#Comment_object_id').val()
					},
					url: " . CJSON::encode(Yii::app()->createUrl('ajax/showcomments')) . ",
					success: function(response) {
						$('div.comments').replaceWith(response);
						$('div.comments div.item:first').hide();
						$('html,body').animate({scrollTop: $('div.comments').offset().top},'slow',function() {
							$('div.comments div.item:first').fadeIn(1000);
						});
					}
				});
				var editor = CKEDITOR.instances['Comment[text]'];
                editor.setData('');
			}
		},
	});
});
	";
	$cs->registerScript('comment_widget_form', $js);
	
?>

<?php $this->render('list', array('comments' => $data_provider->data, 'total' => $data_provider->totalItemCount, 'pages' => $data_provider->pagination)); ?>

<?php if (! Yii::app()->user->isGuest): ?>
	<div class="new_comment">
		<?php $form = $this->beginWidget('CActiveForm', array(
			'id' => 'add_comment',
		)); ?>
		<?php echo $form->hiddenField($comment_model, 'model', array('value' => $model)); ?>
		<?php echo $form->hiddenField($comment_model, 'object_id', array('value' => $object_id)); ?>
		<?php
			$this->widget('ext.ckeditor.CKEditorWidget', array(
				'model' => $comment_model,
				'attribute' => 'text',
				'config' => array(
					'toolbar' => 'Nocut',
				),
			));
		?>
		<div class="button_panel">
			<button class="btn btn-gray-medium cancel"><span><span>Отмена</span></span></button>
			<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
		</div>
		<?php $this->endWidget(); ?>
	</div>
<?php endif; ?>