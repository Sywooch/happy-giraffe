<?php
	$preloadedWaypoints = 1;
	$maxWaypoints = 10;
	
	$cs = Yii::app()->clientScript;
	
	$js = "
		$('#waypoints ul:gt(" . ((($slave_model->isNewRecord) ? $preloadedWaypoints : count($slave_model->waypoints)) - 1) . ")').hide();
	
		function addField()
		{
			$('#waypoints ul:hidden:first').show();
			if ($('#waypoints ul:hidden').length == 0)
			{
				$('#addWaypoint').parent().hide();
			}
		}
	
		$('#addWaypoint').click(function(e) {
			e.preventDefault();
			addField();
		});
		
		$('ul.waypoint a.ok').click(function (e) {
			e.preventDefault();
			//var p = $(this).parents('ul.waypoint');
			//if (p.find('input[type=hidden][value]').length == 2)
			//{
			//	var i = p.find('input[type=text]');
			//	$.each(i, function() {
			//		$(this).replaceWith('<strong>' + $(this).val() + '</strong>');
			//	});
			//}
			addField();
			$('#waypoints ul:visible:last input:first').focus();
		});
		
		$('#CommunityTravelImage_image').MultiFile({
			list: '.downloaded_items',
			STRING: {
				file: '<li><span>" . '$file' . "</span><a class=\"MultiFile-remove\" href=\"#CommunityTravelImage_image_wrap\">Удалить</a></li>',
				remove: ''
			}
		});

	";
	
	$cs	
		->registerScriptFile('/javascripts/jquery.MultiFile.js')
		->registerScript('travel_add', $js);
?>



<div class="">
	<div class="inner-title">Название путешествия:</div>
	<?php echo $form->textField($content_model, 'title'); ?>
	
	<div class="inner-title">Какие страны и города посетили?</div>
	<div class="viseted_it" id="waypoints">
		<?php for ($i = 0; $i < $maxWaypoints; $i++): ?>
			<?php
				if (! $slave_model->isNewRecord && isset($slave_model->waypoints[$i]) && $slave_model->waypoints[$i] instanceof CommunityTravelWaypoint)
				{
					$waypoint_model = $slave_model->waypoints[$i];
				}
				else
				{
					$waypoint_model = new CommunityTravelWaypoint;
				}
			?>
			<ul class="waypoint">
				<li>
					<?php
						$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'model' => $waypoint_model,
							'attribute' => '[' . $i . ']country_name',
		
							'sourceUrl' => $this->createUrl('/geo/geo/countries'),
				
							'options' => array(
								'select' => "js:function (event, ui)
									{
										$('#CommunityTravelWaypoint_" . $i . "_country_id').val(ui.item.id);
										$('#CommunityTravelWaypoint_" . $i . "_city_name').val('');
										$('#CommunityTravelWaypoint_" . $i . "_city_id').removeAttr('value');
									}
								",
							),
						));
					?>
					<?php echo $form->hiddenField($waypoint_model, '[' . $i . ']country_id'); ?>
				</li>
				<li>
					<?php
						$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
							'model' => $waypoint_model,
							'attribute' => '[' . $i . ']city_name',
		
							'source' => "js: function(request, response)
								{
									$.ajax({
										url: '" . $this->createUrl('/geo/geo/cities') . "',
										dataType: 'json',
										data: {
											term: request.term,
											country_id: $('#CommunityTravelWaypoint_" . $i . "_country_id').val()
										},
										success: function (data)
										{
											response(data);
										}
									})
								}",
				
							'options' => array(
								'select' => "js:function (event, ui)
									{
										$('#CommunityTravelWaypoint_" . $i . "_city_id').val(ui.item.id);
									}
								",
							),
						));
					?>
					<?php echo $form->hiddenField($waypoint_model, '[' . $i . ']city_id'); ?>
				</li>
				<li><a href="" class="btn btn-green-small ok"><span><span>ОК</span></span></a></li>
			</ul>
		<?php endfor; ?>
	</div><!-- .viseted_it -->
	<span class="bl_button">
		<button class="btn btn-green-medium" id="addWaypoint"><span><span>Добавить</span></span></button>
	</span>	
	<div class="inner-title">Текст:</div>
	<div class="html_r">
		<?php
			$this->widget('ext.ckeditor.CKEditorWidget', array(
				'model' => $slave_model,
				'attribute' => 'text',
			));
		?>
	</div><!-- .html_r -->
	<div class="add_photos_changer">
		<span>Добавить фотографии:</span>
		<ul>
			<li class="current"><a href="#"><span>По одной</span></a></li>
			<!--<li>|</li>
			<li><a href="#"><span>Сразу много</span></a></li>-->
		</ul>
		<div class="clear"></div>
	</div><!-- .add_photos_changer -->
	<div class="upload-btn">
		<div class="file-fake">
			<button class="btn btn-orange"><span><span>Загрузить фото</span></span></button>
			<?php echo UFiles::fileField(new CommunityTravelImage, 'image', array('name' => 'CommunityTravelImage[image][]')); ?>
		</div>
		<br/>
		Загрузите файл (jpg, gif, png не более 4 МБ)
	</div>
	<ul class="downloaded_items">
		
	</ul>
</div>