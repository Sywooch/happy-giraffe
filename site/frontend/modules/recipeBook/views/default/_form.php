<?php
	$cs = Yii::app()->clientScript;
	
	$js = "
		$('#disease_category').change(function () {
			$.ajax({
				type: 'POST',
				url: '" . $this->createUrl('diseases') . "',
				data: {
					disease_category: $('#disease_category').val()
				},
				success: function(response) {
					$('#cuselFrame-RecipeBookRecipe_disease_id').replaceWith(response);
					cuSel({changedEl: 'select', visRows: 8, scrollArrows: true});
				}
			});
		});
	";
	
	$cs->registerScript('recipeBook_add', $js);
?>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<?php echo CHtml::errorSummary(array_merge(array($model), $ingredients)); ?>

<div>
	<?php echo $model->getAttributeLabel('name'); ?>:
	<?php echo $form->textField($model, 'name'); ?>
</div>

<div>
	<?php echo $model->getAttributeLabel('disease_id'); ?>:
	<?php echo CHtml::dropDownList('disease_category', $model->isNewRecord ? '' : $model->disease->category->id, CHtml::listData(RecipeBookDiseaseCategory::model()->findAll(), 'id', 'name'), array(
		'prompt' => 'Выберите категорию',
	)); ?>
	
	<?php echo $form->dropDownList($model, 'disease_id', $model->isNewRecord ? array() : CHtml::listData($model->disease->category->diseases, 'id', 'name'), array(
		'prompt' => 'Выберите болезнь',
	)); ?>
</div>

<div>
	<?php echo $model->getAttributeLabel('purposes'); ?>:
	<?php echo $form->checkBoxList($model, 'purposeIds', CHtml::listData(RecipeBookPurpose::model()->findAll(), 'id', 'name')); ?>
</div>

<?php if ($model->isNewRecord): ?>
	<?php $ingredient_model = new RecipeBookIngredient; for ($i = 0; $i < 2; $i++): ?>
		<div>
			<?php echo $form->textField($ingredient_model, '[' . $i . ']name'); ?>
			<?php echo $form->textField($ingredient_model, '[' . $i . ']amount'); ?>
			<?php echo $form->dropDownList($ingredient_model, '[' . $i . ']unit', RecipeBookIngredient::getUnitValues(), array(
				'prompt' => 'не указано',
			)); ?>
		</div>
	<?php endfor; ?>
<?php else: ?>
	<?php foreach ($model->ingredients as $i => $ingredient_model): ?>
		<div>
			<?php echo $form->textField($ingredient_model, '[' . $i . ']name'); ?>
			<?php echo $form->textField($ingredient_model, '[' . $i . ']amount'); ?>
			<?php echo $form->dropDownList($ingredient_model, '[' . $i . ']unit', RecipeBookIngredient::getUnitValues(), array(
				'prompt' => 'не указано',
			)); ?>
		</div>
	<?php endforeach; ?>
<?php endif; ?>

<div>
	<?php echo $model->getAttributeLabel('text'); ?>:
	<?php echo $form->textArea($model, 'text'); ?>
</div>

<div>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>