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
	$cs
        ->registerScript('add_video', $js_add_video)->registerCss('add_video', $css_add_video);
?>

	<?php if ($content_model->isNewRecord || (Yii::app()->user->checkAccess('editCommunityContent',
    array('community_id'=>$content_model->rubric->community_id)) ||
    $content_model->author_id == Yii::app()->user->id)):?>
	    <div class="">
    		<div class="inner-title">Заголовок видео</div>
    		<?php echo $form->textField($content_model, 'title'); ?>

    		<?php if(Yii::app()->user->checkAccess('editor')): ?>

    			<?php echo $form->checkbox($content_model, 'by_happy_giraffe'); ?> От Веселого Жирафа

    		<?php endif; ?>
    	</div>
	<?php endif ?>
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
			$this->widget('ext.ckeditor.CKEditorWidget', array(
				'model' => $slave_model,
				'attribute' => 'text',
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
			

			    <?php if ($content_model->isNewRecord): ?>
    				<?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData($rubrics, 'id', 'title'),
                    array(
                        'prompt' => 'Выберите рубрику',
                        'class'=>'chzn',
                    )); ?>
    			<?php else: ?>
    				<?php echo CHtml::dropDownList('community_id', $community->id, CHtml::listData($communities, 'id', 'title'),
    					array(
    						'prompt' => 'Выберите сообщество',
                            'ajax' => array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajax/rubrics'),
                                'success' => 'function(data){
							    $("#CommunityContent_rubric_id").html(data);
							    $("#CommunityContent_rubric_id").trigger("liszt:updated");
                            }',
                            ),
    						'disabled' => Yii::app()->user->checkAccess('transfer post') ? '' : 'disabled',
                            'class'=>'chzn',
    					)
    				); ?></p>

    				<?php echo $form->dropDownList($content_model, 'rubric_id', CHtml::listData($community->rubrics, 'id', 'title'),
    					array(
    						'prompt' => 'Выберите рубрику',
    						'disabled' => Yii::app()->user->checkAccess('transfer post') ? '' : 'disabled',
                            'class'=>'chzn',
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