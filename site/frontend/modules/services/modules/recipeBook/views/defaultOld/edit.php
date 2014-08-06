<?php
	$preloadedIngredients = 1;
	$ingredient_model = new RecipeBookIngredient;
	$nextIndex = $model->isNewRecord ? $preloadedIngredients : count($model->ingredients);

	$cs = Yii::app()->clientScript;

	$js = "
		function addField()
		{
			$('#ingredientTmpl').tmpl({num: nextIndex}).appendTo('.ingr_f_recipe_tb');
			$('.ingr_f_recipe_tb select').chosen();
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
					$('#RecipeBookRecipe_disease_id').html(response);
					$('#RecipeBookRecipe_disease_id').trigger('liszt:updated');
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
		
		$('#source_container > div').hide();
		$('#source_" . $model->source_type . "').show();
	
		$('input[name=\"RecipeBookRecipe[source_type]\"]').change(function () {
			$('#source_container > div').hide();
			$('#source_' + $(this).val()).show();
		});

		$('#book').live('click', function() {
			$.ajax({
				type: 'POST',
				data: {
					source_type: $('input[name=\"CommunityPost[source_type]\"]:checked').val(),
					book_author: $('input[name=\"CommunityPost[book_author]\"]').val(),
					book_name: $('input[name=\"CommunityPost[book_name]\"]').val()
				},
				url: '" . CController::createUrl('ajax/source') . "',
				success: function(response) {
					$('#source_submit_container').html(response);
				}
			});
			return false;
		});

		$('#internet').live('click', function() {
			$.ajax({
				type: 'POST',
				data: {
					source_type: $('input[name=\"CommunityPost[source_type]\"]:checked').val(),
					internet_link: $('input[name=\"CommunityPost[internet_link]\"]').val(),
				},
				url: '" . CController::createUrl('ajax/source') . "',
				success: function(response) {
					$('#source_submit_container').html(response);
				}
			});
			return false;
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
	<td><?php echo CHtml::activeTextField($ingredient_model, '[${num}]title', array('class' => 't_ingr')); ?></td>
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

			<div class="new-footer">
				<?php echo CHtml::errorSummary(array_merge(array($model), $ingredients)); ?>
				<div class="add_rec_field">
					<span>Добавить рецепт:</span>
					<ins>Заголовок рецепта:</ins>
					<?php echo $form->textField($model, 'title'); ?>
				</div><!-- .add_rec_field -->
				<div class="settings">

					<div class="settings-l">
						<div class="inner-title">Выберите болезнь:</div>

						<?php echo CHtml::dropDownList('disease_category', $model->isNewRecord ? '' : $model->disease->category->id, CHtml::listData(RecipeBookDiseaseCategory::model()->findAll(), 'id', 'title'), array(
							'prompt' => 'Выберите категорию',
                            'class'=>'chzn'
						)); ?>

						<?php echo $form->dropDownList($model, 'disease_id', $model->isNewRecord ? array() : CHtml::listData($model->disease->category->diseases, 'id', 'title'), array(
							'prompt' => 'Выберите болезнь',
                            'class'=>'chzn'
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
							<?php echo $form->checkBoxList($model, 'purposeIds', CHtml::listData(RecipeBookPurpose::model()->findAll(), 'id', 'title'), array(
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
							<?php foreach ($model->ingredients as $num => $ingredient): ?>
								<tr>
									<td><?php echo CHtml::activeTextField($ingredient, "[$num]title", array('class' => 't_ingr')); ?></td>
									<td><?php echo CHtml::activeTextField($ingredient, "[$num]amount", array('class' => 't_much')); ?></td>
									<td>
										<?php echo CHtml::activeDropDownList($ingredient, "[$num]unit", RecipeBookIngredient::getUnitValues(), array(
											'prompt' => 'не указано',
                                            'class'=>'chzn'
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
				<div class="settings">

					<div class="settings-l">
						<div class="inner-title">Укажите источник</div>

						<input type="radio" class="RadioClass" id="v1" value="me" name="<?php echo get_class($model); ?>[source_type]"/>
						<label for="v1" class="RadioLabelClass">Я автор</label>

						<input type="radio" class="RadioClass" id="v2" value="internet" name="<?php echo get_class($model); ?>[source_type]"/>
						<label for="v2" class="RadioLabelClass">Интернет-ресурс</label>

						<input type="radio" class="RadioClass" id="v3" value="book" name="<?php echo get_class($model); ?>[source_type]"/>
						<label for="v3" class="RadioLabelClass">Книга</label>

						<div class="clear"></div>
						<div class="sel" id="source_container">
							<div id="source_me">

							</div>

							<div id="source_internet">
								<?php echo $form->textField($model, 'internet_link', array('placeholder' => 'http://www.', 'class' => 'big')); ?>
								<?php echo CHtml::link('<span><span>ОК</span></span>', '#', array('class' => 'btn btn-green-small', 'id' => 'internet')); ?>
								<div class="clear"></div>
							</div>

							<div id="source_book">
								<?php echo $form->textField($model, 'book_author', array('placeholder' => 'Автор')); ?>
								<?php echo $form->textField($model, 'book_name', array('placeholder' => 'Название книги')); ?>
								<?php echo CHtml::link('<span><span>ОК</span></span>', '#', array('class' => 'btn btn-green-small', 'id' => 'book')); ?>
								<div class="clear"></div>
							</div>
						</div>
						<div class="sel" id="source_submit_container">

						</div>
					</div>
					<div class="settings-r">
						<div class="peach">
							<div class="t"></div>
							<div class="b"></div>
							<span class="mdash">&mdash;</span>
							<div class="in">
								Уважайте интеллектуальную собственность!<br/>Указывайте автора или источник статьи
							</div>
						</div>
					</div>
					<div class="clear">
					</div>
				</div>
				<div class="clear"></div>

				<div class="button_panel">
					<button class="btn btn-gray-medium"><span><span>Отменить</span></span></button>
					<button class="btn btn-green-medium"><span><span>Добавить</span></span></button>
				</div>
			</div>

<?php $this->endWidget(); ?>