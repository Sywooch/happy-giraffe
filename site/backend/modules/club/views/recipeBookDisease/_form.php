<?php
/* @var $this Controller
 * @var $form CActiveForm
 */
?><?php echo CHtml::link('К таблице', array('RecipeBookDisease/admin')) ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'recipe-book-disease-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Поля с <span class="required">*</span> обязательны.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'category_id'); ?>
        <?php echo $form->dropDownList($model, 'category_id', CHtml::listData(RecipeBookDiseaseCategory::model()->findAll(), 'id', 'title')); ?>
        <?php echo $form->error($model, 'category_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'text')); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'reasons_name'); ?>
        <?php echo $form->textField($model, 'reasons_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'reasons_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'symptoms_name'); ?>
        <?php echo $form->textField($model, 'symptoms_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'symptoms_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'diagnosis_name'); ?>
        <?php echo $form->textField($model, 'diagnosis_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'diagnosis_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'treatment_name'); ?>
        <?php echo $form->textField($model, 'treatment_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'treatment_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'prophylaxis_name'); ?>
        <?php echo $form->textField($model, 'prophylaxis_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'prophylaxis_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'reasons_text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'reasons_text')); ?>
        <?php echo $form->error($model, 'reasons_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'symptoms_text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'symptoms_text')); ?>
        <?php echo $form->error($model, 'symptoms_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'treatment_text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'treatment_text')); ?>
        <?php echo $form->error($model, 'treatment_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'prophylaxis_text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'prophylaxis_text')); ?>
        <?php echo $form->error($model, 'prophylaxis_text'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'diagnosis_text'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'diagnosis_text')); ?>
        <?php echo $form->error($model, 'diagnosis_text'); ?>
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

    <div class="row">
        <?php echo $form->labelEx($model, 'slug'); ?>
        <?php echo $form->textField($model, 'slug', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'slug'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>
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