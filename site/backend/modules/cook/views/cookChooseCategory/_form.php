<?php
$basePath = Yii::getPathOfAlias('application.modules.club.views.cookChooseCategory.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);
?>

<?php echo CHtml::link('К таблице', array('admin')) ?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-choose-category-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title_accusative'); ?>
        <?php echo $form->textField($model, 'title_accusative', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'title_accusative'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'description')); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description_center'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'description_center')); ?>
        <?php echo $form->error($model, 'description_center'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description_extra'); ?>
        <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array('model' => $model, 'attribute' => 'description_extra')); ?>
        <?php echo $form->error($model, 'description_extra'); ?>
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