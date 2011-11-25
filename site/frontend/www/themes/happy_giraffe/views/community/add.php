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
			});'
		);
?>

<div class="inner">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<h1>Добавить:</h1>
	
	<div class="new">
		<div class="new-header">
			<span class="current">Статью</span>
			<span><a href="">Видео</a></span>
		</div>
		<div class="">
			<h2>Заголовок статьи</h2>
			<?php echo $form->textField($content_model, 'name') ?>
			
			<h2>Текст статьи</h2>
			<?php
				$this->widget('ext.imperaviRedactor.EImperaviRedactorWidget', array(
					'model' => $article_model,
					'attribute' => 'text',
					'options' => array(
						'toolbar' => 'main',
						'cssPath' => Yii::app()->theme->baseUrl.'/css/',
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
				<h2>Выберите сообщество и рубрику</h2>
				
				<?php echo CHtml::dropDownList('community_id', '', array('1000' => 'Выберите сообщество') + CHtml::listData($communities, 'id', 'name'),
					array(
						'ajax' => array(
							'type' => 'POST',
							'url' => CController::createUrl('ajax/rubrics'),
							'update' => '#cusel-scroll-CommunityContent_rubric_id',
						),
					)
				); ?></p>
				
				<?php echo $form->dropDownList($content_model, 'rubric_id', array('1000' => 'Выберите рубрику')); ?>
				
			</div>
			<div class="settings-r">
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tr.png" class="tr"/>
				<div class="peach">
					Обязательно и т.д и т.п.
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
		
		<div class="settings">
			
			<div class="settings-l">
				<h2>Укажите источник</h2>
				
				
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
				<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/tr.png" class="tr"/>
				<div class="peach">
					Обязательно и т.д и т.п.<br/>
					Обязательно и т.д и т.п.<br/>
					Обязательно и т.д и т.п.<br/>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>

		
		<div class="button_panel">
			<a href="<?=CController::createUrl('community/list', $cancel_params)?>" class="g-button grey">
				<span class="fill">Отменить</span>
				<span class="right"></span>
				<span class="left"></span>
			</a>
			<a href="" class="g-button yellow-big">
				<span class="fill">Предпросмотр</span>
				<span class="right"></span>
				<span class="left"></span>
			</a>
			<div class="g-button">
				<div class="fill">
					<input type="submit" value="Добавить"/>
				</div>
				<div class="left">
				</div>
				<div class="right">
				</div>
			</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>