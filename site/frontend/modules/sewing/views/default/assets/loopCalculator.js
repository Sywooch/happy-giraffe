/**
 * Author: alexk984
 * Date: 25.04.12
 */

var loopCalculator = {
    calc:function () {
        var c1 = parseInt($('#LoopCalculationForm_sample_width_sm').val());
        var c2 = parseInt($('#LoopCalculationForm_sample_height_sm').val());
        var p1 = parseInt($('#LoopCalculationForm_sample_width_p').val());
        var p2 = parseInt($('#LoopCalculationForm_sample_height_p').val());

        var c3 = parseInt($('#LoopCalculationForm_width').val());
        var c4 = parseInt($('#LoopCalculationForm_height').val());

        var p3 = Math.round(p1 * (c3 / c1));
        var p4 = Math.round(p2 * (c4 / c2));

        $('#result').html('<div class=\"form_block pink clearfix\">' +
            '<p><span>' + p3 + '</span> петель</p>' +
            '<p><span>' + p4 + '</span> рядов</p>' +
            '</div>');

        return false;
    }
}