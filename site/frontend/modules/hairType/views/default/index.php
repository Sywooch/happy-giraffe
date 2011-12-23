<style type="text/css">
    #test-wrap {
        width: 400px;
        height: 200px;
        overflow: hidden;
        border: 1px solid #000;
        position: relative;
    }

    #test-inner {
        position: absolute;
        width: 1200px;
        height: 200px;
        top: 0;
        left: 0;
    }

    #test-wrap:after {
        clear: both;
    }

    .step {
        width: 400px;
        height: 200px;
        float: left;
    }
</style>
<script type="text/javascript">
    var active_step = 1;
    var filled = false;
    var step_result = null;
    var result = new Array();
    var step_count;

    $(function () {
        step_count = $("div.step").size();

        $('#next-step-button').click(function () {
            filled = false;
            $('#step' + active_step + ' input').each(function () {
                if ($(this).is(':checked')) {
                    filled = true;
                    step_result = $('#step' + active_step + ' input').index($(this)) + 1;
                }
            });

            if (filled) {
                result.push(step_result);
//                console.log(result);

                if (step_count == active_step)
                    return ShowResult();
                $('#test-inner').animate({left:-active_step * 400}, 500);
                active_step++;
            } else {
                $('.error').show().fadeOut(2000);
            }
            return false;
        });
    });

    function ShowResult() {
        var arr2 = new Array(0, 0, 0, 0, 0, 0);
        for (var i = 0; i <= result.length - 1; i++) {
            arr2[result[i]]++;
        }
        var max = 0;
        var res = 1;
        for (var i = 0; i <= arr2.length - 1; i++) {
            if (arr2[i] > max){
                max = arr2[i];
                res = i;
            }
        }
        if (res == 1){
            $('#test-wrap').html('Нормальные');
        }
        if (res == 2){
            $('#test-wrap').html('Жирные');
        }
        if (res == 3){
            $('#test-wrap').html('Сухие');
        }
        if (res == 4){
            $('#test-wrap').html('Смешанные (жирные корни, сухие кончики)');
        }
    }
</script>
<div class="error" style="display: none;">
    Выберите вариант
</div>
<div id="test-wrap" class="cleafix">
    <div id="test-inner" class="cleafix">
        <div class="step" id="step1">
            <p>Привычная для вас частота мытья волос</p>
            <?php echo CHtml::radioButtonList('step1', '', array(
            '1' => '1 раз в 2-3 дня',
            '2' => 'Каждый день и чаще',
            '3' => '1 раз в 6-8 дней и реже',
            '4' => '1 раз в 3-4 дня',
        )) ?>
        </div>
        <div class="step" id="step2">
            <p>Привычная для вас частота мытья волос</p>
            <?php echo CHtml::radioButtonList('step2', '', array(
            '1' => '1 раз в 2-3 дня',
            '2' => 'Каждый день и чаще',
            '3' => '1 раз в 6-8 дней и реже',
            '4' => '1 раз в 3-4 дня',
        )) ?>
        </div>
        <div class="step" id="step3">
            <p>Привычная для вас частота мытья волос</p>
            <?php echo CHtml::radioButtonList('step3', '', array(
            '1' => '1 раз в 2-3 дня',
            '2' => 'Каждый день и чаще',
            '3' => '1 раз в 6-8 дней и реже',
            '4' => '1 раз в 3-4 дня',
        )) ?>
        </div>
    </div>
</div>
<?php echo CHtml::link('Следующий', '#', array('id' => 'next-step-button')) ?>