<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('#addRecipeForm').delegate('#CookRecipe_preparation_duration_m', 'change', function() {
            var h = $(this).prev('input');
            if (parseInt($(this).val()) > 59) {
                h.val(Math.floor(parseInt($(this).val()) / 60) + parseInt(h.val()));
                $(this).val(parseInt($(this).val()) % 60);
            }
        });
    ";

    $cs->registerScript('CookRecipe_add', $js);
?>


<?=CHtml::errorSummary(array($recipe))?>

<?php $form = $this->beginWidget('CActiveForm', array('id' => 'addRecipeForm')); ?>

    <div>
        <p><?php echo $form->labelEx($recipe, 'title'); ?></p>
        <p><?php echo $form->textField($recipe, 'title'); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'preparation_duration'); ?></p>
        <p><?php echo $form->textField($recipe, 'preparation_duration_h', array('size' => 2)); ?>:<?php echo $form->textField($recipe, 'preparation_duration_m', array('size' => 2)); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'cooking_duration'); ?></p>
        <p><?php echo $form->textField($recipe, 'cooking_duration_h', array('size' => 2)); ?>:<?php echo $form->textField($recipe, 'cooking_duration_m', array('size' => 2)); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'cuisine_id'); ?></p>
        <p><?php echo $form->dropDownList($recipe, 'cuisine_id', CHtml::listData($cuisines, 'id', 'title'), array('prompt' => '---')); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'type'); ?></p>
        <p><?php echo $form->dropDownList($recipe, 'type', $recipe->types, array('prompt' => '')); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'method'); ?></p>
        <p><?php echo $form->dropDownList($recipe, 'method', $recipe->methods, array('prompt' => '')); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'servings'); ?></p>
        <p><?php echo $form->textField($recipe, 'servings'); ?></p>
    </div>

    <div>
        <p><?php echo $form->labelEx($recipe, 'text'); ?></p>
        <p><?php echo $form->textArea($recipe, 'text'); ?></p>
    </div>

    <?=CHtml::submitButton('Сохранить')?>

<?php $this->endWidget(); ?>

