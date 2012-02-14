<ul>
	<li>
		<?php
			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'id' => 'CommunityTravelWaypoint_' . $i . '_country_name',
				'name' => 'CommunityTravelWaypoint[' . $i . '][country_name]',

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
				'id' => 'CommunityTravelWaypoint_' . $i . '_city_name',
				'name' => 'CommunityTravelWaypoint[' . $i . '][city_name]',

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
	<li><a href="" class="btn btn-green-small"><span><span>ОК</span></span></a></li>
</ul>