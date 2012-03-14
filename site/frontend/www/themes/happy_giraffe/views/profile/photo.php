<?php
$cs = Yii::app()->clientScript;
$js = "
$('#User_pic_small').change(function() {
	$('#photoForm').submit();
});
$('.photo-upload a.remove').click(function () {
        $.ajax({
            url:'" . Yii::app()->createUrl("profile/removePhoto") . "',
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status){
                    $('.img-box').html('');
                    $('.user-fast a.ava').html('');
                }
            },
            context:$(this)
        });

        return false;
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
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
    ),
)); ?>

<p class="line-title">Ваша фотография</p>

<div class="photo-upload">

    <div class="left">
        <?php if ($ava = $this->user->pic_small->getUrl('ava')): ?>
        <div class="img-box <?php echo ($this->user->gender == 1) ? 'female' : 'male' ?> ava">
            <?php echo CHtml::image($ava, $this->user->first_name); ?>
            <a href="" class="remove"></a>
        </div>
        <?php else: ?>
        <div class="img-box <?php echo ($this->user->gender == 1) ? 'female' : 'male' ?> ava"></div>
        <?php endif; ?>
        <p>Лучше добавить свою настоящую фотографию, чтобы ваши друзья смогли найти вас на «Веселом жирафе».</p>
    </div>

    <div class="upload-btn">
        <div class="file-fake">
            <button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
            <?php echo UFiles::fileField($this->user, 'pic_small'); ?>
        </div>
        <br/>
        Загрузите файл (jpg, gif, png не более 4 МБ)
    </div>
</div>
<?php echo CHtml::hiddenField('returnUrl', $returnUrl) ?>
<?php $this->endWidget(); ?>