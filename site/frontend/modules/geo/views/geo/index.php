<?php Yii::app()->clientScript->registerScriptFile('/javascripts/chosen.jquery.min.js'); ?>
<ul>
    <li>
        <?php echo CHtml::dropDownList('country_id', 174,
        CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'), array('class' => 'chzn-select with-search')); ?>
    </li>
    <li>
        <?php echo CHtml::dropDownList('region_id', 42,
        CHtml::listData(GeoRusRegion::model()->findAll(array('order' => 'pos,id', 'select' => 'id,name')), 'id', 'name'),
        array('empty' => '', 'class' => 'chzn-select with-search')); ?>
    </li>
    <li>
        <?php echo CHtml::dropDownList('district_id', '', array(), array('empty' => '', 'class' => 'chzn-select with-search')); ?>

        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'id' => 'Location_city_name',
            'name' => 'Location[city_name]',

            'source' => "js: function(request, response)
					{
						$.ajax({
							url: '" . $this->createUrl('/geo/geo/cities') . "',
							dataType: 'json',
							data: {
								term: request.term,
								country_id: $('#country_id').val(),
								region_id: $('#region_id').val(),
								district_id: $('#district_id').val()
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
							$('#Location_city_id').val(ui.item.id);
						}
					",
            ),
        ));
        ?>
        <?php echo CHtml::hiddenField('Location[city_id]', ''); ?>
    </li>
    <li><a href="" class="btn btn-green-small"><span><span>ОК</span></span></a></li>
</ul>
<?php //$this->widget('AvatarWidget', array('user' => User::getUserById(Yii::app()->user->getId()))); ?>
<script type="text/javascript">
    $(function () {
        $("#country_id").chosen().change(function () {
            if ($(this).val() == 174) {
                $('#region_id').show();
            } else {
                $('#region_id').hide();
            }
        });

        if ($('#country_id').val() != 174) {
            $('#region_id').hide();
        }
        if ($('#region_id').val() == 42 || $('#region_id').val() == 59) {
            $('#district_id').hide();
            $('#Location_city_name').hide();
        }

        $('#region_id').chosen().change(function () {
            if ($(this).val() == 42 || $(this).val() == 59) {
                $('#district_id').hide();
                $('#Location_city_name').hide();
            } else {
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("/geo/geo/districts") ?>',
                    data:{
                        country_id:$('#country_id').val(),
                        region_id:$(this).val()
                    },
                    type:'POST',
                    success:function (response) {
                        $('#district_id').show();
                        $('#Location_city_name').show();

                        $('#district_id').html(response);
                        $('#Location_city_id').val('');
                        $('#Location_city_name').val('');
                    },
                    context:$(this)
                });
            }
        });

        $('#district_id').chosen().change(function () {
            $('#Location_city_id').val('');
            $('#Location_city_name').val('');
        });
    });
</script>