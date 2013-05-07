<h1>Характеристики ингредиента</h1>

<?php
$nutritionals = new CookIngredientNutritional();
$nutritionals->ingredient_id = $model->id;

?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'cook-ingredients-nutritionals-create-form',
    'enableAjaxValidation' => true,
    'action' => CHtml::normalizeUrl(array('cookIngredients/linkNutritional')),
    'clientOptions' => array(
        'validateOnSubmit' => true,
        'validateOnChange' => false,
        'validateOnType' => false,
        'validationUrl' => $this->createUrl('cookIngredients/linkNutritional'),
        'afterValidate' => "js:function(form, data, hasError) { if (!hasError){ Nutritionals.Link();} else { return false;} }",
    )));
    ?>

    <?php
    echo $form->errorSummary($nutritionals);
    $form->error($nutritionals, 'nutritional_id');
    $form->error($nutritionals, 'value');
    ?>

    <?php echo $form->hiddenField($nutritionals, 'ingredient_id'); ?>

    <div class="row">
        <?php echo $form->dropDownList($nutritionals, 'nutritional_id', CookNutritional::getNutritionals()); ?>
        <?php echo $form->textField($nutritionals, 'value'); ?>
        <?php echo CHtml::submitButton('Добавить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>





<div id="nutritionals">

    <?php
    $this->renderPartial('_form_nutritionals_list', array('model' => $model));
    ?>

</div>

