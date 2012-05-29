<style type="text/css">
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
            foreach (CookSpicesCategories::model()->getCategories() as $category) {
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
                <?php echo ($model->ingredient->title) ? $model->ingredient->title : "выбрать ингредиент"; ?>
            </a>
            <?php echo $form->error($model, 'ingredient_id'); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'content'); ?></td>
        <td>
            <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); ?>
            <div><?php echo $form->error($model, 'content'); ?></div>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'photo'); ?></td>
        <td>
            <?php echo $form->textField($model, 'photo', array('size' => 60, 'maxlength' => 255)); ?>
            <div><?php echo $form->error($model, 'photo'); ?></div>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?></td>
    </tr>
</table>

<?php $this->endWidget(); ?>

<div>
    <h1>Советы</h1>

    <?php
    $hint = new CookSpicesHints();

    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'spices-hints-form',
        'enableAjaxValidation' => true,
        'action' => CHtml::normalizeUrl(array('club/cookSpices/addHint')),
        'clientOptions' => array(
            'validateOnSubmit' => true,
            'validateOnChange' => false,
            'validateOnType' => false,
            'validationUrl' => $this->createUrl('club/cookSpices/addHint'),
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


