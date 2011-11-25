<?php
	$cs = Yii::app()->clientScript;
	$js = "
$('#User_pic_small').change(function() {
	$('#photoForm').submit();
});
	";
	$cs->registerScript('profile_photo', $js);
?>

<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Ваша фотография</b>',
); ?>

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'photoForm',
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
)); ?>
	<div class="profile-form-in">
		
		<p class="line-title">Ваша фотография</p>
		
		<div class="photo-upload">
			
			<div class="left">
				<?php if ($ava = $this->user->pic_small->getUrl('ava')): ?>
					<div class="img-box">
						<?php echo CHtml::image($ava, $this->user->first_name); ?>
						<a href="" class="remove">Удалить</a>
					</div>
				<?php else: ?>
					<div class="img-box noimg"><img src="/images/ava_noimg_<?php echo $this->user->gender ? 'male' : 'female'; ?>.png" /></div>
				<?php endif; ?>
				<p>Лучше добавить свою настоящую фотографию, чтобы ваши друзья смогли найти вас на «Веселом жирафе».</p>
			</div>
			
			<div class="upload-btn">
				<div class="file-fake">
					<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
					<?php echo UFiles::fileField($this->user,'pic_small'); ?>
				</div>
				<br/>
				Загрузите файл (jpg, gif, png не более 4 МБ)
			</div>
			
		</div>
		
	</div>
</div>
<div class="bottom">
	&nbsp;
</div>
<?php $this->endWidget(); ?>