<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model CookSpice
 */

$basePath = Yii::getPathOfAlias('application.modules.club.views.cookSpices.assets');
$baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);

?><style type="text/css">
    table.form {
        width: 100%
    }

    table.form td {
        padding: 5px 20px
    }

    table.form td.categories {
        vertical-align: top;
        line-height: 20px
    }

    table.form td.categories label {
        cursor: pointer
    }

    div.hint {
        border: 1px solid #EEE;
        margin: 5px 0;
        padding: 10px
    }

    div.hint div {
        margin-top: 10px
    }

    .errorMessage {
        color: #ff0000;
    }

    #spices-hints-form {
        margin-bottom: 15px
    }

</style>

<p><?php echo CHtml::link('К таблице', array('admin')) ?></p>



<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-spices-form',
    'enableAjaxValidation' => false,
)); ?>


<?php echo $form->errorSummary($model); ?>



<table class="form">
    <tr>
        <td style="width: 80px">
            <?php echo $form->labelEx($model, 'title'); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
            <div><?php echo $form->error($model, 'title'); ?></div>
        </td>
        <td rowspan="5" class="categories" style="width: 220px">
            <?
            foreach (CookSpiceCategory::model()->getCategories() as $category) {
                ?><div>
                <input type="checkbox" name="category[<?=$category['id'];?>]" id="category<?=$category['id'];?>" value="<?=$category['id'];?>"
                    <?php if (in_array($category['id'], $model->getCategories())) { ?> checked="checked" <?php } ?> >
                <?php

                echo '<label class="required" for="category' . $category['id'] . '">' . $category['title'] . '</label></div>';
            }
            ?>
        </td>
    </tr>
    <tr>
        <td style="width: 80px">
            <?php echo $form->labelEx($model, 'title_ablative'); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'title_ablative', array('size' => 60, 'maxlength' => 255)); ?>
            <div><?php echo $form->error($model, 'title_ablative'); ?></div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->labelEx($model, 'ingredient_id'); ?>
        </td>
        <td>

            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'sourceUrl' => Yii::app()->createUrl('club/cookSpices/ac'),
                'name' => 'ac',
                'id' => 'ac',
                'htmlOptions' => array(
                    'style' => 'display:none'
                )
            ));

            echo $form->hiddenField($model, 'ingredient_id');
            ?>

            <a href="#" id="ingredient_text" onclick="Spice.selectIngredient(event);">
                <?php echo (isset($model->ingredient)) ? $model->ingredient->title : "выбрать ингредиент"; ?>
            </a>
            <?php echo $form->error($model, 'ingredient_id'); ?>
        </td>
    </tr>
    <?php if (!$model->isNewRecord) { ?>
    <tr>
        <td><?php echo $form->labelEx($model, 'content'); ?></td>
        <td>
            <?php $this->widget('site.frontend.extensions.ckeditor.CKEditorWidget', array(
                'model' => $model,
                'attribute' => 'content',
            )); ?>
            <div><?php echo $form->error($model, 'content'); ?></div>
        </td>
    </tr>
    <?php } ?>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo CHtml::submitButton($model->isNewRecord ? 'Создать и продолжить' : 'Сохранить'); ?></td>
    </tr>
</table>

<?php $this->endWidget(); ?>

<?php if (!$model->isNewRecord) { ?>

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
                <?php echo CHtml::fileField('photo', '', array('class'=>'photo-file')); ?>
                <?php $this->endWidget(); ?>
            </div>
        </td>
    </tr>
</table>

<div>
    <h1>Советы</h1>

    <?php
    $hint = new CookSpicesHints();

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'spices-hints-form',
        'enableAjaxValidation' => true,
        'action' => CHtml::normalizeUrl(array('cookSpices/addHint')),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('cookSpices/addHint'),
            'afterValidate' => "js:function(form, data, hasError) { if (!hasError){ Spice.addHint();} else { return false;} }",
        )));

    echo $form->hiddenField($hint, 'spice_id', array('value' => $model->id));
    ?>

    <div class="row">
        <?php echo $form->textArea($hint, 'content', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($hint, 'content'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Добавить совет'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>


<div id="hints">
    <?php $this->renderPartial('_form_hints', array('model' => $model)); ?>
</div>

<?php } ?>