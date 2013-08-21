<?=CHtml::link('К таблице', array('admin'))?>

<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'service-form',
        'enableAjaxValidation'=>false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'title'); ?>
        <?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'community_id'); ?>
        <?php echo $form->dropDownList($model, 'community_id', CHtml::listData(Community::model()->findAll(), 'id', 'title'), array('empty' => '--')); ?>
        <?php echo $form->error($model, 'community_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'url'); ?>
        <?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'url'); ?>
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

</div><!-- form -->

<?php if (!$model->isNewRecord) { ?>
<div>
    <h1>Фотография</h1>
    <table width="100%" style="margin: 30px 0;">
        <tr>
            <td>Выберите фото</td>
            <td>
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
                    <?php echo CHtml::fileField('photo', '', array('class' => 'photo-file')); ?>
                    <?php $this->endWidget(); ?>
                </div>
            </td>
        </tr>
    </table>
</div>
<?php } ?>

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