/**
 * Author: alexk984
 * Date: 25.04.12
 */
$(function () {
    $('#YarnCalcForm_project').change(function () {
        $.ajax({
            url:'#',
            data:{id:$('#YarnCalcForm_project').val()},
            dataType:'JSON',
            type:'POST',
            success:function (data) {
                $('#YarnCalcForm_size').html(data.size).trigger("liszt:updated");
                $('#YarnCalcForm_gauge').html(data.gauge).trigger("liszt:updated");
                $('#YarnCalcForm_size_chzn').trigger("liszt:updated");
                $('#YarnCalcForm_gauge_chzn').trigger("liszt:updated");
            }
        });
    });
});

function StartCalc() {
    $.ajax({
        url:'#',
        data:$('#yarn-calculator-form').serialize(),
        type:'POST',
        success:function (data) {
            $('#result').html('<div class="yarn_result"><span class="result_sp">' +
                data + PluralNumber(data, ' метр', '', 'а', 'ов') + '</span> пряжи потребуется ' +
                '<ins>Результаты расчета приблизительные*</ins></div>');
        }
    });

    return false;
}

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