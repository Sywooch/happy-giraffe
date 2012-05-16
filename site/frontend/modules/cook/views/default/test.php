<style>
    textarea {
        width: 100%;
        height: 200px
    }

    .parse {
        border-collapse: collapse;
        margin: 30px 0;
    }

    .parse td {
        border: 1px solid #CCC;
        padding: 2px 10px;
    }
</style>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'test-form-test-form',
    'enableAjaxValidation' => false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'recipeIngredients'); ?>
        <?php echo $form->textArea($model, 'recipeIngredients'); ?>
        <?php echo $form->error($model, 'recipeIngredients'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>

    <?php $this->endWidget(); ?>


</div><!-- form -->



<table class="parse">
    <?php
    if (count($result['ingredients'])) {
        foreach ($result['ingredients'] as $ingr) {
            echo '<tr>';
            echo '<td>' . $ingr['text'] . '</td>';
            echo '<td>';
            if (isset($ingr['ingredient']['row']))
                echo $ingr['ingredient']['row']['title'];
            echo '</td>';
            echo '<td>';
            if (isset($ingr['qty']))
                echo $ingr['qty'];
            echo '</td>';
            echo '<td>';
            if (isset($ingr['unit']['row']))
                echo $ingr['unit']['row']['title'];
            echo '</td>';
            echo '</tr>';
        }
    }
    ?>
</table>





<pre>
    <?php
    print_r($result);
    ?>
</pre>