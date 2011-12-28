<?php
	$preloadedIngredients = 3;
	$ingredient_model = new RecipeBookIngredient;
	$nextIndex = $model->isNewRecord ? $preloadedIngredients : count($model->ingredients);

	$cs = Yii::app()->clientScript;
	
	$js = "
		function addField()
		{
			$('#ingredientTmpl').tmpl({num: nextIndex}).appendTo('.ingr_f_recipe_tb');
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
		
		$('a.more_lk').click(function(e) {
			e.preventDefault();
			addField();
		});
		
		$('a.remove').live('click', function(e) {
			e.preventDefault();
			$(this).parents('tr').remove();
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
<tr>
	<td><?php echo CHtml::activeTextField($ingredient_model, '[${num}]name', array('class' => 't_ingr')); ?></td>
	<td><?php echo CHtml::activeTextField($ingredient_model, '[${num}]amount', array('class' => 't_much')); ?></td>
	<td>
		<?php echo CHtml::activeDropDownList($ingredient_model, '[${num}]unit', RecipeBookIngredient::getUnitValues(), array(
			'prompt' => 'не указано',
		)); ?>
	</td>
	<td><a href="#" class="remove"><img src="/images/bg_popup_close.gif" alt="" title="" /></a></td>
</tr>
</script>

<?php $form = $this->beginWidget('CActiveForm'); ?>

	<div id="baby">
		<div class="inner">
			<div class="baby_recipes_service">
				<ul class="handbook_changes_u">
					<li class="current_t"><a href="#">Главная</a></li>
					<li><a href="#"><span>Болезни по алфавиту</span></a></li>
					<li><a href="#"><span>Болезни по типу</span></a></li>
				</ul>
			</div><!-- .baby_recipes_service -->
			<div class="new-footer">
				<?php echo CHtml::errorSummary(array_merge(array($model), $ingredients)); ?>
				<div class="add_rec_field">
					<span>Добавить рецепт:</span>
					<ins>Заголовок рецепта:</ins>
					<?php echo $form->textField($model, 'name'); ?>
				</div><!-- .add_rec_field -->
				<div class="settings">
					
					<div class="settings-l">
						<div class="inner-title">Выберите болезнь:</div>
						
						<?php echo CHtml::dropDownList('disease_category', $model->isNewRecord ? '' : $model->disease->category->id, CHtml::listData(RecipeBookDiseaseCategory::model()->findAll(), 'id', 'name'), array(
							'prompt' => 'Выберите категорию',
						)); ?>
	
						<?php echo $form->dropDownList($model, 'disease_id', $model->isNewRecord ? array() : CHtml::listData($model->disease->category->diseases, 'id', 'name'), array(
							'prompt' => 'Выберите болезнь',
						)); ?>
						
					</div>
					<div class="settings-r">
						<div class="peach">
							<div class="t"></div>
							<div class="b"></div>								
							<span class="mdash">&mdash;</span>
							<div class="in">
								Обязательно укажите тип заболевания и болезнь, в которых Вы  хотите разместить данный рецепт.
							</div>
						</div>
					</div>
					<div class="clear">
					</div>
				</div>
				
				<div class="settings">
					
					<div class="settings-l">
						<div class="inner-title">Назначение рецепта</div>
						<table class="fr_recipe_tb">
							<?php echo $form->checkBoxList($model, 'purposeIds', CHtml::listData(RecipeBookPurpose::model()->findAll(), 'id', 'name'), array(
								'template' => '<tr><td>{input} {label}</td></tr>',
							)); ?>
						</table>
						<div class="clear"></div>
					</div>
					<div class="settings-r">
						<div class="peach">
							<div class="t"></div>
							<div class="b"></div>
							<span class="mdash">&mdash;</span>							
							<div class="in">
								Обязательно укажите назначение рецепта, в котором Вы  хотите разместить данный рецепт.
							</div>
						</div>
					</div>
					<div class="clear">
					</div>
				</div>
				<div class="settings-l">
					<div class="inner-title">Ингредиенты для рецепта</div>
					<table class="ingr_f_recipe_tb">
						<tr>
							<th>Ингредиент</th>
							<th>Кол-во</th>
							<th>Ед. измерения</th>
							<th>Удалить</th>
						</tr>
						<?php if (! $model->isNewRecord): ?>
							<?php foreach ($model->ingredients as $i => $ingredient): ?>
								<tr>
									<td><?php echo CHtml::activeTextField($ingredient, '[${num}]name', array('class' => 't_ingr')); ?></td>
									<td><?php echo CHtml::activeTextField($ingredient, '[${num}]amount', array('class' => 't_much')); ?></td>
									<td>
										<?php echo CHtml::activeDropDownList($ingredient, '[${num}]unit', RecipeBookIngredient::getUnitValues(), array(
											'prompt' => 'не указано',
										)); ?>
									</td>
									<td><a href="#" class="remove"><img src="/images/bg_popup_close.gif" alt="" title="" /></a></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</table>
					<a href="#" class="more_lk">Добавить еще поле</a>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
				<div class="html_redactor_sett">
					<span class="title_red">Описание рецепта</span>
					<?php
						$this->widget('ext.ckeditor.CKEditorWidget', array(
							'model' => $model,
							'attribute' => 'text',
						));
					?>
				</div><!-- html_redactor_sett -->
			<!--	<div class="settings">
			
			<div class="settings-l">
				<div class="inner-title">Укажите источник</div>
				<ul class="wrote_w">
					<li><input type="radio" class="RadioClass" id="w1" name="set"/>
					<label for="w1" class="RadioLabelClass">Я автор</label></li>
					<li><input type="radio" class="RadioClass" id="w2" name="set"/>
					<label for="w2" class="RadioLabelClass">Интернет-ресурс</label></li>
					<li><input type="radio" class="RadioClass" id="w3" name="set"/>
					<label for="w3" class="RadioLabelClass">Книга</label></li>
				</ul>
				<div class="clear"></div>
				<div class="sel">
					<ul class="wrote_u">
						<li><input type="text" value="" placeholder="Автор"/></li>
						<li><input type="text" value="" placeholder="Название книги"/></li>
						<li><a href="" class="btn btn-green-small"><span><span>ОК</span></span></a></li>
					</ul>
					<div class="clear"></div>
				</div>
			</div>
			<div class="settings-r">
				<div class="peach">
					<div class="t"></div>
					<div class="b"></div>
					<span class="mdash">&mdash;</span>							
					<div class="in">
						Уважайте интелектуальную собственность!<br/>Указывайте автора или источник статьи
					</div>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>-->
				<div class="clear"></div>
				
				<div class="button_panel">
					<button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
					<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
				</div>
			</div>
		</div>

</div>  	
<div class="push"></div>

<?php $this->endWidget(); ?>