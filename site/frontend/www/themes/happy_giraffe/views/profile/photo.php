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
        <?php
        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
            'user' => $this->user,
            'small' => true,
        ));
        ?>
        <p>Лучше добавить свою настоящую фотографию, чтобы ваши друзья смогли найти вас на «Веселом жирафе».</p>
    </div>
    <div id="change_ava" style="display: none"></div>
    <div class="upload-btn" id="refresh_upload">
        <?php
        $fileAttach = $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
            'model' => $this->user,
        ));
            $fileAttach->button();
        $this->endWidget();
        ?>
        Загрузите файл (jpg, gif, png не более 4 МБ)
    </div>
</div>
<?php echo CHtml::hiddenField('returnUrl', $returnUrl) ?>
<?php $this->endWidget(); ?>