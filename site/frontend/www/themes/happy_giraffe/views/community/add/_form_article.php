<?php

	$cs = Yii::app()->clientScript;

	$js = "
		$('#source_container > div').hide();
		$('#source_" . $slave_model->source_type . "').show();
	
		$('input[name=\"CommunityArticle[source_type]\"]').change(function () {
			$('#source_container > div').hide();
			$('#source_' + $(this).val()).show();
		});

		$('#book').live('click', function() {
			$.ajax({
				type: 'POST',
				data: {
					source_type: $('input[name=\"CommunityArticle[source_type]\"]:checked').val(),
					book_author: $('input[name=\"CommunityArticle[book_author]\"]').val(),
					book_name: $('input[name=\"CommunityArticle[book_name]\"]').val()
				},
				url: '" . CController::createUrl('ajax/source') . "',
				success: function(response) {
					$('#source_submit_container').html(response);
				}
			});
			return false;
		});

		$('#internet').live('click', function() {
			$.ajax({
				type: 'POST',
				data: {
					source_type: $('input[name=\"CommunityArticle[source_type]\"]:checked').val(),
					internet_link: $('input[name=\"CommunityArticle[internet_link]\"]').val(),
				},
				url: '" . CController::createUrl('ajax/source') . "',
				success: function(response) {
					$('#source_submit_container').html(response);
				}
			});
			return false;
		});
	";
	

	
	$cs
		->registerScript('form_article', $js)
	;
		
?>

	<div class="">
		<div class="inner-title">Заголовок статьи</div>
		<?php echo $form->textField($content_model, 'name'); ?>
	
		<?php if(Yii::app()->user->checkAccess('moder')): ?>
			<div class="inner-title">Title</div>
			<?php echo $form->textField($content_model, 'meta_title'); ?>
	
			<div class="inner-title">Description</div>
			<?php echo $form->textField($content_model, 'meta_description'); ?>
		
			<div class="inner-title">Keywords</div>
			<?php echo $form->textField($content_model, 'meta_keywords'); ?>
			
			<?php echo $form->checkbox($content_model, 'by_happy_giraffe'); ?> От Веселого Жирафа
	
		<?php endif; ?>
		
		<div class="inner-title">Текст статьи</div>
		<?php
			$this->widget('ext.ckeditor.CKEditorWidget', array(
				'model' => $slave_model,
				'attribute' => 'text',
			));
		?>
	</div>
	
</div>

<div class="clear"></div>
<div class="new-footer">
	
	<div class="settings">
		
		<div class="settings-l">
			<div class="inner-title">Выберите сообщество и рубрику</div>
			
			<?php if ($content_model->isNewRecord): ?>
				<?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData($community->rubrics, 'id', 'name'), array('prompt' => 'Выберите рубрику')); ?>
			<?php else: ?>
				<?php echo CHtml::dropDownList('community_id', $community->id, CHtml::listData($communities, 'id', 'name'),
					array(
						'prompt' => 'Выберите сообщество',
						'ajax' => array(
							'type' => 'POST',
							'url' => CController::createUrl('ajax/rubrics'),
							'update' => '#cusel-scroll-CommunityContent_rubric_id',
						),
						'disabled' => Yii::app()->user->checkAccess('moder') ? '' : 'disabled',
					)
				); ?></p>
			
				<?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData($community->rubrics, 'id', 'name'),
					array(
						'prompt' => 'Выберите рубрику',
						'disabled' => Yii::app()->user->checkAccess('moder') ? '' : 'disabled',
					)
				); ?>
			<?php endif; ?>
			
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
			
			<?php echo $form->radioButton($slave_model, 'source_type', array('value' => 'me', 'id' => 'v1', 'class' => 'RadioClass')); ?>
			<label for="v1" class="RadioLabelClass">Я автор</label>
			
			<?php echo $form->radioButton($slave_model, 'source_type', array('value' => 'internet', 'id' => 'v2', 'class' => 'RadioClass')); ?>
			<label for="v2" class="RadioLabelClass">Интернет-ресурс</label>

			<?php echo $form->radioButton($slave_model, 'source_type', array('value' => 'book', 'id' => 'v3', 'class' => 'RadioClass')); ?>
			<label for="v3" class="RadioLabelClass">Книга</label>

			<div class="clear"></div>
			<div class="sel" id="source_container">
				<div id="source_me">
				
				</div>
				
				<div id="source_internet">
					<?php echo $form->textField($slave_model, 'internet_link', array('placeholder' => 'http://www.', 'class' => 'big')); ?>
					<?php echo CHtml::link('<span><span>ОК</span></span>', '#', array('class' => 'btn btn-green-small', 'id' => 'internet')); ?>
					<div class="clear"></div>
				</div>
				
				<div id="source_book">
					<?php echo $form->textField($slave_model, 'book_author', array('placeholder' => 'Автор')); ?>
					<?php echo $form->textField($slave_model, 'book_name', array('placeholder' => 'Название книги')); ?>
					<?php echo CHtml::link('<span><span>ОК</span></span>', '#', array('class' => 'btn btn-green-small', 'id' => 'book')); ?>
					<div class="clear"></div>
				</div>
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