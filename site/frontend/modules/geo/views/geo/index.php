<?php $user = User::getUserById(Yii::app()->user->id); ?>
<?php $region_id = empty($user->settlement_id) ? null : $user->settlement->region_id ?>
<?php $district_id = empty($user->settlement_id) ? null : $user->settlement->district_id ?>
<?php $city_id = empty($user->settlement_id) ? null : $user->settlement_id ?>
<?php $city_name = empty($user->settlement_id) ? null : $user->settlement->name ?>
<?php $street_id = empty($user->street_id) ? null : $user->street->name ?>
<ul>
    <li class="with-search">
        <?php echo CHtml::dropDownList('country_id', $user->country_id,
        array('' => '') + CHtml::listData(GeoCountry::model()->findAll(array('order' => 'pos')), 'id', 'name'),
        array(
            'class' => 'chzn-select',
            'data-placeholder' => 'Выберите страну',
        )); ?>
    </li>
    <li class="with-search">
        <?php echo CHtml::dropDownList('region_id', $region_id,
        array('' => '') + CHtml::listData(GeoRusRegion::model()->findAll(array('order' => 'pos,id', 'select' => 'id,name')), 'id', 'name'),
        array(
            'class' => 'chzn-select',
            'data-placeholder' => 'Выберите регион',
//            'style' => ($user->country_id != 174) ? 'display: none;' : ''
        )); ?>
    </li>
    <li class="with-search">
        <?php echo CHtml::dropDownList('district_id', $district_id, array(), array(
        'empty' => '',
        'class' => 'chzn-select',
        'data-placeholder' => 'Выберите район',
//        'style' => (empty($region_id) || $region_id == 42 || $region_id == 59) ? 'width: 300px;display: none;' : 'width: 300px;'
        'style' => 'width: 300px;'
    )); ?>
    </li>
    <li>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'id' => 'city_name',
            'name' => 'city_name',
            'value' => $city_name,
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
							$('#city_id').val(ui.item.id);

                            ShowStreet();
						}
					",
                'htmlOptions' => array(
                    'style' => (empty($region_id)) ? 'display: none;' : '',
                    'placeholder'=>'Выберите город'
                )
            ),
        ));
        ?>
        <?php echo CHtml::hiddenField('city_id', $city_id); ?>
    </li>
    <li>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'id' => 'street_name',
            'name' => 'street_name',
            'value' => empty($user->street)?'':$user->street->name,
            'source' => "js: function(request, response)
					{
						$.ajax({
							url: '" . $this->createUrl('/geo/geo/street') . "',
							dataType: 'json',
							data: {
								term: request.term,
								city_id: $('#city_id').val(),
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
                            $('#street_id').val(ui.item.id);
						}
					",
                'htmlOptions' => array(
                    'style' => (empty($region_id)) ? 'display: none;' : '',
                    'placeholder'=>'улица'
                )
            ),
        ));
        ?>
        <?php echo CHtml::hiddenField('street_id', $user->street_id); ?>
    </li>
    <li>
        <?php echo CHtml::textField('house', $user->house, array(
//        'style' => (empty($street_id) && empty($user->house)) ? 'display: none;' : '',
        'placeholder'=>'дом'
    )) ?>
    </li>
    <li>
        <?php echo CHtml::textField('room', $user->room, array(
        'placeholder'=>'квартира'
//        'style' => (empty($street_id) && empty($user->room)) ? 'display: none;' : '',
    )) ?>
    </li>
    <li><a href="" class="btn btn-green-small"><span><span>ОК</span></span></a></li>
</ul>
<script type="text/javascript">
    $(function () {
        $("#country_id").chosen().change(function () {
            if ($(this).val() == 174) {
                $('#region_id_chzn').show();
                if ($('#region_id').val() != '' && $('#region_id').val() != 42 && $('#region_id').val() != 59) {
                    $('#district_id_chzn').show();
                    $('#city_name').show();
                }
            } else {
                $('#region_id_chzn').hide();
                $('#district_id_chzn').hide();
                $('#city_name').hide();

                HideStreet();
            }
        });

        $('#region_id').chosen().change(function () {
            if ($(this).val() == 42 || $(this).val() == 59 || $(this).val() == '') {
                $('#district_id_chzn').hide();
                $('#city_name').hide();
                if ($(this).val() == ''){
                    $('#street_name').hide();
                    $('#house').hide();
                    $('#room').hide();
                }else{
                    if ($(this).val() == 42)
                        $('#city_id').val(148315);
                    if ($(this).val() == 59)
                        $('#city_id').val(148316);
                    ShowStreet();
                }
            } else {
                $.ajax({
                    url:'<?php echo Yii::app()->createUrl("/geo/geo/districts") ?>',
                    data:{
                        country_id:$('#country_id').val(),
                        region_id:$(this).val()
                    },
                    type:'POST',
                    success:function (response) {
                        $('#district_id_chzn').show();
                        $('#city_name').show();

                        $('#district_id').html(response);
                        $("#district_id").trigger("liszt:updated");
                        $('#city_id').val('');
                        $('#city_name').val('');

                        HideStreet();

                    },
                    context:$(this)
                });
            }
        });

        $('#district_id').chosen().change(function () {
            $('#city_id').val('');
            $('#city_name').val('');

            HideStreet();
        });

        if ($('#country_id').val() != 174) {
            $('#region_id_chzn').hide();
            $('#district_id_chzn').hide();
            $('#city_name').hide();
            HideStreet();
        }

        if ($('#region_id').val() == 42 || $('#region_id').val() == 59) {
            $('#district_id_chzn').hide();
            $('#city_name').hide();
            ShowStreet();
        }else if($('#region_id').val() == ''){
            $('#district_id_chzn').hide();
            $('#city_name').hide();
            HideStreet();
        }
    });

    function ShowStreet(){
        $('#street_name').show();
        $('#house').show();
        $('#room').show();

        $('#street_name').val('');
        $('#street_id').val('');
        $('#house').val('');
        $('#room').val('');
    }
    function HideStreet(){
        $('#street_name').hide();
        $('#house').hide();
        $('#room').hide();
    }
</script>