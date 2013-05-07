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

<?php echo CHtml::link('К таблице', array('cookIngredients/admin')) ?>


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
            <td><?=$form->dropDownList($model, 'category_id', CookIngredientCategory::getCategories());?></td>
            <td><?=$form->error($model, 'category_id');?></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?></td>
            <td>&nbsp</td>
        </tr>
    </table>
    <?php $this->endWidget(); ?>
</div>
