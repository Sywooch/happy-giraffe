<h1>Синонимы ингредиента</h1>

<?php
$nutritionals = new CookIngredientNutritional();
$synonyms = new CookIngredientSynonym();
$synonyms->ingredient_id = $model->id;

?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-ingredients-synonyms-create-form',
    'enableAjaxValidation' => true,
    'action' => CHtml::normalizeUrl(array('cookIngredients/createSynonym')),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('cookIngredients/createSynonym'),
        'afterValidate' => "js:function(form, data, hasError) { if (!hasError){ Nutritionals.createSynonym();} else { return false;} }",
    )));
    ?>

    <?php echo $form->errorSummary($synonyms); ?>

    <?php echo $form->hiddenField($synonyms, 'ingredient_id'); ?>



    <div class="row">
        <?php echo $form->labelEx($synonyms, 'title'); ?>
        <?php echo $form->textField($synonyms, 'title'); ?>
        <?php echo CHtml::submitButton('Добавить'); ?>
        <?php echo $form->error($synonyms, 'title'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>





<div id="synonyms">

    <?php
    $this->renderPartial('_form_synonyms_list', array('model' => $model));
    ?>

</div>

