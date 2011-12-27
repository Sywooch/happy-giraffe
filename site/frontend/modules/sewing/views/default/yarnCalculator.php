<style type="text/css">
    #cuselFrame-project{
        z-index: 12;
    }
    #cuselFrame-size{
        z-index: 11;
    }
</style>
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

        $('.calc_bt').click(function () {
            $.ajax({
                url:'#',
                data:$('#yarn-form').serialize(),
                type:'POST',
                success:function (data) {
                    $('#result').html('<div class="yarn_result"><span class="result_sp">' +
                        data + PluralNumber(data, ' метр', '', 'а', 'ов')+'</span> пряжи потребуется ' +
                        '<ins>Результаты расчета приблизительные*</ins></div>');
                }
            });

            return false;
        });
    });

    function PluralNumber(count, arg0, arg1, arg2, arg3) {
        var result = arg0;
        var last_digit = count % 10;
        var last_two_digits = count % 100;
        if (last_digit == 1 && last_two_digits != 11) result += arg1;
        else if ((last_digit == 2 && last_two_digits != 12)
            || (last_digit == 3 && last_two_digits != 13)
            || (last_digit == 4 && last_two_digits != 14))
            result += arg2;
        else
            result += arg3;
        return result;
    }
</script>
<?php $model = new YarnCalcForm ?>
<div class="embroidery_service">
    <img src="/images/service_much_yarn.jpg" alt="" title="" />
    <div class="list_yarn">
        <form id="yarn-form" action="">
            <ul>
                <li>
                    <ins>Что вяжем?</ins>
								<span class="title_h">
                                    <?php echo CHtml::activeDropDownList($model, 'project', CHtml::listData(YarnProjects::model()->cache(60)->findAll(), 'id', 'name'), array('id' => 'project','class'=>'mn_cal')) ?>
								</span>
                </li>
                <li>
                    <ins>Размер</ins>
								<span class="title_h">
                                    <?php echo CHtml::activeDropDownList($model, 'size', YarnProjects::model()->sizes[$model->size], array('id' => 'size','class'=>"num_cal")) ?><br>
								</span>
                </li>
                <li>
                    <ins>Количество</ins>
								<span class="title_h">
                                    <?php echo CHtml::activeDropDownList($model, 'gauge', YarnProjects::model()->gauges[$model->gauge], array('id' => 'gauge', 'class'=>"yr_cal")) ?>
								</span>
                </li>
                <li>
                    <input type="button" class="calc_bt" value="Рассчитать" />
                </li>
            </ul>
        </form>
    </div><!-- .list_yarn -->
    <div id="result">

    </div>
</div><!-- .embroidery_service -->