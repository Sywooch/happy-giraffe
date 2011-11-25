<?php
	$cs = Yii::app()->clientScript;
	$url = CController::createUrl('ajax/video');
	$js_add_video = "
$('#preview').click(function () {
				$.ajax({
					url: " . CJSON::encode($url) . ",
					type: 'POST',
					data: {
						url: $('#CommunityVideo_link').val(),
					},
					success: function(response) {
						$('.validate .right-v').show();
						$('#preview_container').html(response);
					},
				});
			});
$('.close').click(function () {
	$('.validate .right-v').hide();
	$('#preview_container').html('');
});	
";	
	$css_add_video = "
.validate .right-v {
	display: none;
}";
	$cs->registerScript('add_video', $js_add_video)->registerCss('add_video', $css_add_video)
		->registerScript(
			'rubrics_preload',
			'if($("#community_id").val() != "1000")
			{
				$.ajax({
					type: "POST",
					data: {
						community_id: $("#community_id").val(),
					},
					url: "' . CController::createUrl('ajax/rubrics', array('type_id' => $content_type->id)) . '",
					success: function(response) {
						$("#cusel-scroll-CommunityContent_rubric_id").html(response);
						$("#CommunityContent_rubric_id").val(2);
						cuSel({refreshEl: "#CommunityContent_rubric_id"});
					}
				})
			}'
		);
	;
?>

<div class="inner">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<?php echo $form->hiddenField($content_model, 'type_id', array('value' => $content_type->id)); ?>
	<div class="content-title">Добавить:</div>
	
	<div class="new">
		<div class="new-header">
			<? $this->renderPartial('add/parts/menu', array(
				'content_types' => $content_types,
				'content_type' => $content_type,
				'community_id' => $community_id,
				'rubric_id' => $rubric_id,
			)); ?>
		</div>
		<div class="">
			<div class="inner-title">Заголовок видео</div>
			<?php echo $form->textField($content_model, 'name') ?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<div class="settings no_bg">
		<div class="inner-title">Ссылка на видео</div>	
		<div class="settings-l">
			<?php echo $form->textField($slave_model, 'link') ?>
			
			<div class="validate">
				<div class="left-v">
					<div class="inner-title">Проверить ролик?</div>
					<?php echo CHtml::link('<span><span>ДА</span></span>', '#', array('class' => 'btn btn-green-small', 'id' => 'preview')); ?>
					<div class="clear"></div>
					<!--<p>какой-то текст какой-то текст какой-то текст какой-то текст какой-то текст какой-то текст какой-то текст какой-то текст </p>-->
				</div>
				<div class="right-v">
					<?php echo CHTML::link('', '#', array('class' => 'close')); ?>
					<div id="preview_container"></div>
					
				</div>
			</div>
			
				
			</div>
			<div class="settings-r">
				<div class="peach">
					<div class="t"></div>
					<div class="b"></div>								
					<span class="mdash">&mdash;</span>
					<div class="in">
						Обязательно укажите сообщество и рубрику, в которых Вы  хотите разместить<br/>данную статью.
					</div>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
	<div class="clear"></div>
	
	<div class="new">
		<div>
			<div class="inner-title">Комментарий к видео</div>
			<?php
				$this->widget('ext.imperaviRedactor.EImperaviRedactorWidget', array(
					'model' => $slave_model,
					'attribute' => 'text',
					'options' => array(
						'toolbar' => 'main',
					),
					'htmlOptions' => array(
						'rows' => 10,
					),
				));
			?>
		</div>
		<div class="clear"></div>
	</div>
	
	<div class="clear"></div>
	<div class="new-footer">
		
		<div class="settings">
			
			<div class="settings-l">
				<div class="inner-title">Выберите сообщество и рубрику</div>
				
				<?php echo CHtml::dropDownList('community_id', (!is_null($community_id)) ? $community_id:'0', array('0' => 'Выберите сообщество') + CHtml::listData($communities, 'id', 'name'),
					array(
						'ajax' => array(
							'type' => 'POST',
							'url' => CController::createUrl('ajax/rubrics'),
							'update' => '#cusel-scroll-CommunityContent_rubric_id',
						),
					)
				); ?></p>
				
				<?php echo $form->dropDownList($content_model, 'rubric_id', array('0' => 'Выберите рубрику')); ?>
				
			</div>
			<div class="settings-r">
				<div class="peach">
					<div class="t"></div>
					<div class="b"></div>								
					<span class="mdash">&mdash;</span>
					<div class="in">
						Обязательно укажите сообщество и рубрику, в которых Вы  хотите разместить<br/>данную статью.
					</div>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
		
		
		
		<div class="button_panel">
			<button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
			<!--<button class="btn btn-yellow-medium"><span><span>Предпросмотр</span></span></button>-->
			<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>