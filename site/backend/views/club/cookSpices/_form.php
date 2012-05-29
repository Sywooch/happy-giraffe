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

</style>

<p><?php echo CHtml::link('К таблице', array('admin')) ?></p>



<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-spices-form',
    'enableAjaxValidation' => false,
)); ?>


<?php echo $form->errorSummary($model); ?>



<table class="form">
    <tr>
        <td>
            <?php echo $form->labelEx($model, 'title'); ?>
        </td>
        <td>
            <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255)); ?>
            <div><?php echo $form->error($model, 'title'); ?></div>
        </td>
        <td rowspan="5" class="categories">
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
            <?php
            echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50));
            /*$this->widget('site.backend.extensions.ckeditor.CKEditorWidget', array(
                'model' => $model,
                'attribute' => 'content',
            ));*/
            ?>
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

