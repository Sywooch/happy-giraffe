<script type="text/javascript">
    $(function () {
        $('#project').change(function () {
            $.ajax({
                url:'#',
                data:{id:$('#project').val()},
                dataType:'JSON',
                type:'POST',
                success:function (data) {
                    $('#cuselFrame-size').replaceWith(data.size);
                    $('#cuselFrame-gauge').replaceWith(data.gauge);
                    cuSel({changedEl:'select', visRows:8, scrollArrows:true});
                }
            });
        });

        $('.calc').click(function () {
            $.ajax({
                url:'#',
                data:$('#yarn-form').serialize(),
                type:'POST',
                success:function (data) {
                    $('#result').html(data);
                }
            });

            return false;
        });
    });
</script>
<?php $model = new YarnCalcForm ?>
<form id="yarn-form" name="test" action="" method="post">
    <?php echo CHtml::activeDropDownList($model, 'project', CHtml::listData(YarnProjects::model()->cache(60)->findAll(), 'id', 'name'), array('id' => 'project')) ?>
    <br>

    <?php echo CHtml::activeDropDownList($model, 'size', YarnProjects::model()->sizes[$model->size], array('id' => 'size')) ?><br>

    <?php echo CHtml::activeDropDownList($model, 'gauge', YarnProjects::model()->gauges[$model->gauge], array('id' => 'gauge')) ?>
    <br>

    <?php echo CHtml::submitButton('Расчитать', array('class' => 'calc')) ?>
</form>
<div id="result"></div>