<?php
	$cs = Yii::app()->getClientScript();
	$js = "
$('#takePartForm div.photo').hide();
$('#takePartForm div.photo a.remove').click(function(e) {
	e.preventDefault();
	$('#takePartForm div.photo').hide();
});
$('#takePartForm').iframePostForm({

	post: function() {
		
	},
	complete: function(response) {
		$('#takePartForm div.photo img').attr('src', response)
		$('#takePartForm div.photo').show();
	}
});	
$('#ContestWork_work_image').change(function() {
	$('#takePartForm').submit();
});
$('#agree').change(function() {
	$('#go').toggleClass('disabled').toggleDisabled();
});
$('#go').click(function(e) {
	e.preventDefault();
	$('#takePartForm').attr('action', '" . CController::createUrl('contestWork/create') . "').removeAttr('target');
	$('#takePartForm').submit();
});
	";
	$functions = "
(function($) {
    $.fn.toggleDisabled = function(){
        return this.each(function(){
            this.disabled = !this.disabled;
        });
    };
})(jQuery);
	";
	$cs->registerScript('takePart', $js)->registerScript('takePart_functions', $functions, CClientScript::POS_HEAD);
?>
<?php $this->beginContent('//layouts/main'); ?>

<div class="section-banner">
	<div class="section-nav" style="left:130px;top:30px;">
		<?php
			$this->widget('zii.widgets.CMenu', array(
				'encodeLabel' => false,
				'items' => array(
					array(
						'label' => '<span><span>О конкурсе</span></span>',
						'url' => array('/contest/' . $this->contest->contest_id),
						'active' => $this->action->id == 'view',
						'linkOptions' => array(
							'class' => 'btn btn-blue-shadow',
						),
					),
					array(
						'label' => '<span><span>Правила</span></span>',
						'url' => array('/contest/rules/' . $this->contest->contest_id),
						'active' => $this->action->id == 'rules',
						'linkOptions' => array(
							'class' => 'btn btn-blue-shadow',
						),
					),
					array(
						'label' => '<span><span>Участники</span></span>',
						'url' => array('/contest/list/' . $this->contest->contest_id),
						'active' => $this->action->id == 'list',
						'linkOptions' => array(
							'class' => 'btn btn-blue-shadow',
						),
					),
				),
			));
		?>
	</div>
	<a href="<?php echo Yii::app()->user->isGuest ? '#login' : '#takeapartPhotoContest'; ?>" class="fancy btn btn-red-transparent" style="position:absolute;z-index:5;right:20px;bottom:28px;"><span><span>Участвовать</span></span></a>
	<img src="/images/section_banner_02.jpg" />
</div>
<?php echo $content; ?>
<div style="display:none;">
	
	<div id="takeapartPhotoContest" class="popup">
		
		<a href="javascript:void(0);" onclick="$.fancybox.close();" class="popup-close">Закрыть</a>
		
		<div class="popup-title">Я хочу участвовать в фотоконкурсе</div>
		
		<?php $model = new ContestWork; $form = $this->beginWidget('CActiveForm', array('id' => 'takePartForm', 'action' => CController::createUrl('contestWork/preview'), 'htmlOptions' => array(
			'enctype' => 'multipart/form-data',
		))); ?>
			<div class="form">
				
				<?php echo $form->hiddenField($model, 'work_contest_id', array('value' => $this->contest->contest_id)); ?>	
					
				<div class="a-right upload-file">
					
					<div class="photo">
						<img src="" alt="">
						<a href="" class="remove">Удалить</a>
					</div>
					
					<div class="file-fake">
						<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
						<?php echo UFiles::fileField($model,'work_image'); ?>
					</div>
					
				</div>
				
				<div class="row">
					<div class="row-title">Название фото</div>
					<div class="row-elements"><?php echo $form->textField($model, 'work_title'); ?></div>
				</div>
				
				<div class="clear"></div>
				
				<div class="form-bottom">
					<label><input type="checkbox" id="agree" /> Я согласен с</label> <a href="">Правилами конкурса</a>
					<button class="btn btn-green-arrow-big disabled" disabled="disabled" id="go"><span><span>Участвовать</span></span></button>
				</div>
				
			</div>
		<?php $this->endWidget(); ?>
		
	</div>
	
</div>
<?php $this->endContent(); ?>