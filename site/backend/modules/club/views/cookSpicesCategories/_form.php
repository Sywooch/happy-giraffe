<?php echo CHtml::link('К таблице', array('admin')) ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-spices-categories-form',
    'enableAjaxValidation' => false,
)); ?>



    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array(
        'model' => $model,
        'attribute' => 'content',
    )); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <div class="row buttons">
        <input type="hidden" name="redirect_to" id="redirect_to" value="">
        <?php
        if ($model->isNewRecord) {
            echo CHtml::submitButton('Создать', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        } else {
            echo CHtml::submitButton('Сохранить');
            echo CHtml::submitButton('Сохранить и продолжить', array('onclick' => 'js:$("#redirect_to").val("refresh");'));
        }
        ?>
    </div>

    <?php $this->endWidget(); ?>

<?php if (!$model->isNewRecord) { ?>

    <h2>Фото</h2>
    <div id="photo-upload-block">
        <img src="<?php if (!empty($model->photo_id)) echo $model->photo->getPreviewUrl() ?>" alt="">
        <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'photo_upload',
        'action' => $this->createUrl('addPhoto'),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
        ),
    )); ?>
        <?php echo CHtml::hiddenField('id', $model->id); ?>
        <?php echo CHtml::fileField('photo', '', array('class'=>'photo-file')); ?>
        <?php $this->endWidget(); ?>
    </div>
    <?php } ?>
</div><!-- form -->

<script type="text/javascript">
    $(function () {
        $('#photo_upload').iframePostForm({
            json:true,
            complete:function (response) {
                if (response.status) {
                    $('#photo-upload-block img').attr('src', response.image);
                }
            }
        });

        $('#photo_upload input').change(function () {
            $(this).parents('form').submit();
            return false;
        });

    })
</script>