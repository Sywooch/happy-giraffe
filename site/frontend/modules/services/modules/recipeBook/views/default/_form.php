<?php
	$preloadedIngredients = 3;
	$ingredient_model = new RecipeBookIngredient;
	$nextIndex = $model->isNewRecord ? $preloadedIngredients : count($model->ingredients);

	$cs = Yii::app()->clientScript;
	
	$js = "
		function addField()
		{
			$('#ingredientTmpl').tmpl({num: nextIndex}).appendTo('#ingredients');
			cuSel({changedEl: 'select', visRows: 8, scrollArrows: true});
			nextIndex++;
		}
	
		var nextIndex = " . $nextIndex . ";
	
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
		
		$('#addIngredient').click(function(e) {
			e.preventDefault();
			addField();
		});
		
		$('button.remove').live('click', function(e) {
			e.preventDefault();
			$(this).parent().remove();
		});
	";
	
	if ($model->isNewRecord)
	{
		$js .= "
			for (var i = 0; i < " . $preloadedIngredients . "; i++)
			{
				addField();
			}
		";
	}
	
	$cs
		->registerScriptFile('https://raw.github.com/jquery/jquery-tmpl/master/jquery.tmpl.min.js')
		->registerScript('recipeBook_add', $js);
?>

<script id="ingredientTmpl" type="text/x-jquery-tmpl">
<div>
	<?php echo CHtml::activeTextField($ingredient_model, '[${num}]title'); ?>
	<?php echo CHtml::activeTextField($ingredient_model, '[${num}]amount'); ?>
	<?php echo CHtml::activeDropDownList($ingredient_model, '[${num}]unit', RecipeBookIngredient::getUnitValues(), array(
		'prompt' => 'не указано',
	)); ?>
	<button class="remove">x</button>
</div>
</script>

<?php $form = $this->beginWidget('CActiveForm'); ?>

<?php echo CHtml::errorSummary(array_merge(array($model), $ingredients)); ?>

<div>
	<?php echo $model->getAttributeLabel('title'); ?>:
	<?php echo $form->textField($model, 'title'); ?>
    <?php echo $form->error($model, 'title'); ?>
</div>

<div>
	<?php echo $model->getAttributeLabel('disease_id'); ?>:
	<?php echo CHtml::dropDownList('disease_category', $model->isNewRecord ? '' : $model->disease->category->id, CHtml::listData(RecipeBookDiseaseCategory::model()->findAll(), 'id', 'title'), array(
		'prompt' => 'Выберите категорию',
	)); ?>
	
	<?php echo $form->dropDownList($model, 'disease_id', $model->isNewRecord ? array() : CHtml::listData($model->disease->category->diseases, 'id', 'title'), array(
		'prompt' => 'Выберите болезнь',
	)); ?>
    <?php echo $form->error($model, 'disease_category'); ?>
    <?php echo $form->error($model, 'disease_id'); ?>
</div>

<div>
	<?php echo $model->getAttributeLabel('purposes'); ?>:
	<?php echo $form->checkBoxList($model, 'purposeIds', CHtml::listData(RecipeBookPurpose::model()->findAll(), 'id', 'title')); ?>
</div>

<div id="ingredients">
	<?php if (! $model->isNewRecord): ?>
		<?php foreach ($model->ingredients as $i => $ingredient): ?>
			<div>
				<?php echo $form->textField($ingredient, '[' . $i . ']title'); ?>
				<?php echo $form->textField($ingredient, '[' . $i . ']amount'); ?>
				<?php echo $form->dropDownList($ingredient, '[' . $i . ']unit', RecipeBookIngredient::getUnitValues(), array(
					'prompt' => 'не указано',
				)); ?>
				<button class="remove">x</button>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</div>

<button id="addIngredient">Добавить</button>

<div>
	<?php echo $model->getAttributeLabel('text'); ?>:
	<?php
		$this->widget('ext.ckeditor.CKEditorWidget', array(
			'model' => $model,
			'attribute' => 'text',
		));
	?>
</div>

<div>
	<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
</div>

<?php $this->endWidget(); ?>