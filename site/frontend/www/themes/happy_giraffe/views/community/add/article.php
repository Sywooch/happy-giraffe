<?php
	Yii::app()->getClientScript()
		->registerScript(
			'source_type',
			'$("input[name=source_type]").change(function () {
				var url = "/club/ajax/view?path=source_type/" + $(this).val();
				$("#source_container").load(url);
			});'
		)
		->registerScript(
			'book',
			'$("#book").live("click", function() {
				$.ajax({
					type: "POST",
					data: {
						source_type: $("input[name=source_type]:checked").val(),
						book_author: $("input[name=book_author]").val(),
						book_name: $("input[name=book_name]").val()
					},
					url: "' . CController::createUrl('ajax/source') . '",
					success: function(response) {
						$("#source_submit_container").html(response);
					}
				});
				return false;
			});'
		)
		->registerScript(
			'internet',
			'$("#internet").live("click", function() {
				$.ajax({
					type: "POST",
					data: {
						source_type: $("input[name=source_type]:checked").val(),
						internet_link: $("input[name=internet_link]").val(),
					},
					url: "' . CController::createUrl('ajax/source') . '",
					success: function(response) {
						$("#source_submit_container").html(response);
					}
				});
				return false;
			});'
		)
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
			<div class="inner-title">Заголовок статьи</div>
			<?php echo $form->textField($content_model, 'name') ?>
			
			<div class="inner-title">Текст статьи</div>
			<?php
				$this->widget('ext.imperaviRedactor.EImperaviRedactorWidget', array(
					'model' => $slave_model,
					'attribute' => 'text',
					'options' => array(
						'image_upload' => $this->createUrl('ajax/imageUpload'),
						'toolbar' => 'custom',
					),
					'htmlOptions' => array(
						'rows' => 10,
					),
				));
			?>
		</div>
		
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
		
		<div class="settings">
			
			<div class="settings-l">
				<div class="inner-title">Укажите источник</div>
				
				
				<input type="radio" class="RadioClass" id="v1" value="me" name="source_type"/>
				<label for="v1" class="RadioLabelClass">Я автор</label>
				
				<input type="radio" class="RadioClass" id="v2" value="internet" name="source_type"/>
				<label for="v2" class="RadioLabelClass">Интернет-ресурс</label>

				<input type="radio" class="RadioClass" id="v3" value="book" name="source_type"/>
				<label for="v3" class="RadioLabelClass">Книга</label>

				<div class="clear"></div>
				<div class="sel" id="source_container">
					
				</div>
				<div class="sel" id="source_submit_container">

				</div>
			</div>
			<div class="settings-r">
				<div class="peach">
					<div class="t"></div>
					<div class="b"></div>
					<span class="mdash">&mdash;</span>							
					<div class="in">
						Уважайте интелектуальную собственность!<br/>Указывайте автора или источник статьи
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