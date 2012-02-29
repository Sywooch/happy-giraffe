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
                        data + PluralNumber(data, ' метр', '', 'а', 'ов') + '</span> пряжи потребуется ' +
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
    <img src="/images/service_much_yarn.jpg" alt="" title=""/>

    <div class="list_yarn">
        <form id="yarn-form" action="">
            <ul>
                <li>
                    <ins>Что вяжем?</ins>
								<span class="title_h">
                                    <?php echo CHtml::activeDropDownList($model, 'project', CHtml::listData(YarnProjects::model()->cache(60)->findAll(), 'id', 'name'), array('id' => 'project', 'class' => 'mn_cal')) ?>
								</span>
                </li>
                <li>
                    <ins>Размер</ins>
								<span class="title_h">
                                    <?php echo CHtml::activeDropDownList($model, 'size', YarnProjects::model()->sizes[$model->size], array('id' => 'size', 'class' => "num_cal")) ?>
                                    <br>
								</span>
                </li>
                <li>
                    <ins>Количество</ins>
								<span class="title_h">
                                    <?php echo CHtml::activeDropDownList($model, 'gauge', YarnProjects::model()->gauges[$model->gauge], array('id' => 'gauge', 'class' => "yr_cal")) ?>
								</span>
                </li>
                <li>
                    <input type="button" class="calc_bt" value="Рассчитать"/>
                </li>
            </ul>
        </form>
    </div>
    <!-- .list_yarn -->
    <div id="result">

    </div>
</div><!-- .embroidery_service -->
<div class="seo-text">
    <h1 class="summary-title">Сколько пряжи для вязания нужно?</h1>

    <p>Вы хотите связать жилет для мужа, платье для себя или пинетки для будущего малыша, но не знаете, на что хватит
        пряжи дома, а на что – лучше купить в магазине?</p>

    <div class="brushed">
        <h3>Воспользуйтесь нашим сервисом!</h3>

        <p>Это очень просто. Для начала вам нужно связать образец в виде квадрата со сторонами 10 сантиметров. Потом –
            подсчитать количество петель, уместившихся в одном ряду.</p>

        <p>Вводим в специальную форму:</p>
        <ul>
            <li>Название изделия,</li>
            <li>Его размер,</li>
            <li>Количество петель, уместившихся в одном ряду образца.</li>
        </ul>
        <p>Через секунду вы получите результат, сколько метров пряжи вам потребуется.</p>
    </div>

    <p><b>Важно:</b></p>
    <ul>
        <li>При вывязывании ажурных узоров с крупными отверстиями пряжи может понадобиться меньше, но лучше взять
            рассчитанное количество.
        </li>
        <li>Если вы планируете вывязывать объёмный узор – косы, шишки, узорную резинку, дополнительные или накладные
            элементы изделия – пряжи может понадобиться значительно больше. В этом случае количество пряжи лучше
            увеличить на 10 – 20%.
        </li>
    </ul>
    <p><b>Удачного вам вязания!</b></p>
</div>