<?php
	$cs = Yii::app()->clientScript;

	$js = "
		$('#source_container > div').hide();
		$('#source_" . $slave_model->source_type . "').show();
	
		$('input[name=\"CommunityPost[source_type]\"]').change(function () {
			$('#source_container > div').hide();
			$('#source_' + $(this).val()).show();
		});

		$('#book').live('click', function() {
			$.ajax({
				type: 'POST',
				data: {
					source_type: $('input[name=\"CommunityPost[source_type]\"]:checked').val(),
					book_author: $('input[name=\"CommunityPost[book_author]\"]').val(),
					book_name: $('input[name=\"CommunityPost[book_name]\"]').val()
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
					source_type: $('input[name=\"CommunityPost[source_type]\"]:checked').val(),
					internet_link: $('input[name=\"CommunityPost[internet_link]\"]').val(),
				},
				url: '" . CController::createUrl('ajax/source') . "',
				success: function(response) {
					$('#source_submit_container').html(response);
				}
			});
			return false;
		});
		
		$('#CommunityContent_by_happy_giraffe').change(function() {
			var s = $('div.settings:eq(1)');
			if ($(this).is(':checked')) s.hide();
			else s.show();
		});
		
		$('#CommunityContent_by_happy_giraffe').trigger('change');
	";
	

	
	$cs->registerScript('form_post', $js);
		
?>

<?php if ($content_model->isNewRecord || (Yii::app()->user->checkAccess('editCommunityContent',
    array('community_id'=>$content_model->rubric->community_id, 'user_id' => Yii::app()->user->id)))):?>
	<div class="">
		<div class="inner-title">Заголовок статьи</div>

		<?php echo $form->textField($content_model, 'title'); ?>
	
		<?php if(Yii::app()->user->checkAccess('editor')): ?>

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
<?php endif; ?>
</div>

<div class="clear"></div>
<div class="new-footer">
	
	<div class="settings">
		
		<div class="settings-l">
			<div class="inner-title">Выберите сообщество и рубрику</div>

			<?php if ($content_model->isNewRecord): ?>
				<?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData($rubrics, 'id', 'title'),
                array(
                    'prompt' => 'Выберите рубрику',
                    'class'=>'chzn'
                )); ?>
			<?php else: ?>
                <?php if ($content_model->isFromBlog): ?>
                    <?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData(Yii::app()->user->model->blog_rubrics, 'id', 'name'),
                        array(
                            'prompt' => 'Выберите рубрику',
                            'class'=>'chzn'
                        )
                    ); ?>
                <?php else: ?>
                    <?php echo CHtml::dropDownList('community_id', $community->id, CHtml::listData($communities, 'id', 'title'),
                        array(
                            'prompt' => 'Выберите сообщество',
                            'class'=>'chzn',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajax/rubrics'),
                                'success' => 'function(data){
                                    $("#CommunityContent_rubric_id").html(data);
                                    $("#CommunityContent_rubric_id").trigger("liszt:updated");
                                }',
                            ),
                            'disabled' => Yii::app()->user->checkAccess('transfer post') ? '' : 'disabled',
                        )
                    ); ?>
                    <?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData($community->rubrics, 'id', 'title'),
                        array(
                            'prompt' => 'Выберите рубрику',
                            'disabled' => Yii::app()->user->checkAccess('transfer post') ? '' : 'disabled',
                            'class'=>'chzn'
                        )
                    ); ?>
                <?php endif; ?>
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
			
			<input type="radio" class="RadioClass" id="v1" value="me" name="<?php echo get_class($slave_model); ?>[source_type]"/>
			<label for="v1" class="RadioLabelClass">Я автор</label>
			
			<input type="radio" class="RadioClass" id="v2" value="internet" name="<?php echo get_class($slave_model); ?>[source_type]"/>
			<label for="v2" class="RadioLabelClass">Интернет-ресурс</label>

			<input type="radio" class="RadioClass" id="v3" value="book" name="<?php echo get_class($slave_model); ?>[source_type]"/>
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
					Уважайте интеллектуальную собственность!<br/>Указывайте автора или источник статьи
				</div>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>