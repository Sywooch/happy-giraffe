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
        width: 2800px;
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
        var v1 = arr2[1];
        var v2 = arr2[2];
        var v3 = arr2[3];
        var v4 = arr2[4];

        if (v1 > v2 && v1 > v3 && v1 > v4) {
            $('#test-wrap').html('Нормальные');
            return;
        }
        if (v1 > v2 && v1 > v3 && v1 == v4) {
            $('#test-wrap').html('Смешанные (жирные корни, сухие кончики)');
            return;
        }
        if (v2 > v1 && v2 > v3 && v2 > v4) {
            $('#test-wrap').html('Жирные');
            return;
        }
        if (v2 > v1 && v2 > v3 && v2 == v4) {
            $('#test-wrap').html('Жирные');
            return;
        }
        if (v2 == v1 && v2 > v3 && v2 > v4) {
            $('#test-wrap').html('Жирные');
            return;
        }
        if (v3 > v1 && v3 > v2 && v3 > v4) {
            $('#test-wrap').html('Сухие');
            return;
        }
        if (v3 > v1 && v3 > v2 && v3 == v4) {
            $('#test-wrap').html('Сухие');
            return;
        }
        if (v3 == v1 && v3 > v2 && v3 > v4) {
            $('#test-wrap').html('Сухие');
            return;
        }
        if (v4 > v1 && v4 > v2 && v4 > v3) {
            $('#test-wrap').html('Смешанные (жирные корни, сухие кончики)');
            return;
        }

        $('#test-wrap').html('Невозможно определить тип волос');
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
        <div class="step" id="step4">
                    <p>Привычная для вас частота мытья волос</p>
                    <?php echo CHtml::radioButtonList('step4', '', array(
                    '1' => '1 раз в 2-3 дня',
                    '2' => 'Каждый день и чаще',
                    '3' => '1 раз в 6-8 дней и реже',
                    '4' => '1 раз в 3-4 дня',
                )) ?>
                </div>
        <div class="step" id="step5">
                    <p>Привычная для вас частота мытья волос</p>
                    <?php echo CHtml::radioButtonList('step5', '', array(
                    '1' => '1 раз в 2-3 дня',
                    '2' => 'Каждый день и чаще',
                    '3' => '1 раз в 6-8 дней и реже',
                    '4' => '1 раз в 3-4 дня',
                )) ?>
                </div>
        <div class="step" id="step6">
                    <p>Привычная для вас частота мытья волос</p>
                    <?php echo CHtml::radioButtonList('step6', '', array(
                    '1' => '1 раз в 2-3 дня',
                    '2' => 'Каждый день и чаще',
                    '3' => '1 раз в 6-8 дней и реже',
                    '4' => '1 раз в 3-4 дня',
                )) ?>
                </div>
        <div class="step" id="step7">
                    <p>Привычная для вас частота мытья волос</p>
                    <?php echo CHtml::radioButtonList('step7', '', array(
                    '1' => '1 раз в 2-3 дня',
                    '2' => 'Каждый день и чаще',
                    '3' => '1 раз в 6-8 дней и реже',
                    '4' => '1 раз в 3-4 дня',
                )) ?>
                </div>
    </div>
</div>
<?php echo CHtml::link('Следующий', '#', array('id' => 'next-step-button')) ?>