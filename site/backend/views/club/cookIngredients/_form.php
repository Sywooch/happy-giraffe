<style type="text/css">
    table.iform td, th {
        padding: 2px 5px
    }

    div.form {
        margin: 15px 0;
        padding: 5px;
        border: 1px solid #CCC
    }

    table#fcontainer {
        width: 100%
    }

    table#fcontainer td {
        vertical-align: top;
        padding: 0 10px
    }

    h1 {
        padding-bottom: 10px
    }
</style>

<?php echo CHtml::link('К таблице', array('club/CookIngredients/admin')) ?>


<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-ingredients-form',
    'enableAjaxValidation' => false,
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <table class="iform general">
        <tr>
            <td><?=$form->labelEx($model, 'title');?></td>
            <td><?=$form->textField($model, 'title', array('size' => 60, 'maxlength' => 255));?></td>
            <td><?=$form->error($model, 'title');?></td>
        </tr>
        <tr>
            <td><?=$form->labelEx($model, 'category_id');?></td>
            <td><?=$form->dropDownList($model, 'category_id', CookIngredientsCategories::getCategories());?></td>
            <td><?=$form->error($model, 'category_id');?></td>
        </tr>
        <?php
        if (!$model->isNewRecord) {
            ?>
            <tr>
                <td><?=$form->labelEx($model, 'unit_id');?></td>
                <td><?=$form->dropDownList($model, 'unit_id', CookUnits::getUnits());?></td>
                <td><?=$form->error($model, 'unit_id');?></td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td><?=$form->labelEx($model, 'density');?></td>
            <td><?=$form->textField($model, 'density', array('size' => 10, 'maxlength' => 10));?></td>
            <td><?=$form->error($model, 'density');?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?></td>
            <td>&nbsp</td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>


<div>
    <?php
    if (!$model->isNewRecord) {
        ?>

        <table id="fcontainer">
            <tr>
                <td>
                    <?php $this->renderPartial('_form_nutritionals', array('model' => $model));?>
                </td>
                <td>
                    <?php $this->renderPartial('_form_units', array('model' => $model)); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php $this->renderPartial('_form_synonyms', array('model' => $model)); ?>
                </td>
            </tr>
        </table>

        <?php


    }
    ?>
</div>

