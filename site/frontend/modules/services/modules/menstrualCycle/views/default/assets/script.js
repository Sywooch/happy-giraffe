/**
 * User: alexk984
 * Date: 25.04.12
 */

var started = false;
$(function () {
    $('body').delegate('div.choice_month a#next-month', 'click', function () {
        var month = $('#review_month').val();
        if (month == '')
            return false;
        var year = $('#review_year').val();

        month++;
        if (month == 13) {
            month = 1;
            year++;
            $('#review_year').val(year);
        }
        $('#review_month').val(month);
        LoadCalendar();
        return false;
    });

    $('body').delegate('div.choice_month a#prev-month', 'click', function () {
        var month = $('#review_month').val();
        if (month == '')
            return false;
        var year = $('#review_year').val();

        month--;
        if (month == 0) {
            month = 12;
            year--;
            $('#review_year').val(year);
        }

        $('#review_month').val(month);
        LoadCalendar();
        return false;
    });

    $('body').delegate('.cal_item', 'hover', function (event) {
        if (event.type == 'mouseenter') {
            $(this).find('.hint').stop(true, true).fadeIn();
        } else {
            $(this).find('.hint').stop(true, true).fadeOut();
        }
    });
    $('body').delegate('.cal_item_default', 'hover', function (event) {
        if (event.type == 'mouseenter') {
            $(this).find('.hint').stop(true, true).fadeIn();
        } else {
            $(this).find('.hint').stop(true, true).fadeOut();
        }
    });

    $('.btn-yellow-medium').click(function () {
        $('#menstrual-cycle-form').submit();
    });
});

function StartCalc() {
    var d = new Date();
    $('#review_month').val($('#MenstrualCycleForm_month').val());
    $('#review_year').val($('#MenstrualCycleForm_year').val());
    LoadCalendar();
    return false;
}
function LoadCalendar() {
    $.ajax({
        url:'/menstrualCycle/calculate/',
        data:$('#menstrual-cycle-form').serialize(),
        type:'POST',
        success:function (data) {
            $('#result').fadeOut(100, function () {
                $('#result').html(data);
                $('#result').fadeIn(100);
            });
            $('html,body').animate({scrollTop:$('#result').offset().top}, 'fast');
            started = true;
        }
    });
}