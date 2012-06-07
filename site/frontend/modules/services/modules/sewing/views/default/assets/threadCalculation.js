/**
 * Author: alexk984
 * Date: 25.04.12
 */
var conf = new Array();

$(function () {
    conf[11] = 0.0025249;
    conf[14] = 0.00196;
    conf[16] = 0.001694;
    conf[18] = 0.0014689;
    conf[20] = 0.001272;
    conf[22] = 0.0010958;
});

function StartCalc() {
    var krestikov = parseInt($('#ThreadCalculationForm_cross_count').val());
    if (isNaN(krestikov)) {
        $('#result').html('');
        return false;
    }
    var kanva = parseInt($('#ThreadCalculationForm_canva').val());
    var s = parseInt($('#ThreadCalculationForm_threads_num').val());

    var threads = krestikov * conf[kanva] * s;
    var str = threads.toFixed(1) + ' метров или ';
    var bundles = Math.ceil(threads / 8);
    str += bundles + ' ';
    var last_digit = bundles.toString();

    var last_2digit = last_digit.substring(last_digit.length - 2, last_digit.length);
    last_digit = last_digit.substring(last_digit.length - 1, last_digit.length);
    var bundle_word = 'мотков';
    if (last_digit == 1)
        bundle_word = 'моток';
    if (last_digit > 1 && last_digit < 5)
        bundle_word = 'мотка';

    if (last_2digit > 4 && last_2digit < 20)
        bundle_word = 'мотков';

    $('#result').html('<div class="thread_result"><span class="result_sp">' + threads.toFixed(1)
        + PluralNumber(threads.toFixed(1), ' метр', '', 'а', 'ов') + '</span> или<b>'
        + bundles + PluralNumber(bundles, ' мот', 'ок', 'ка', 'ков')
        + '</b> <ins>Результаты расчета приблизительные*</ins></div>');
    //var r = '<span class="result_sp">234 метра</span> или<b>30 мотков</b> <ins>Результаты расчета приблизительные*</ins>';
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