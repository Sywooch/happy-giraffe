var started = false;
function StartCalc() {
    var d = new Date();
    $('#review_month').val($('#OvulationForm_con_month').val());
    $('#review_year').val($('#OvulationForm_con_year').val());
    LoadCalendar();
    return false;
}

function LoadCalendar() {
    $.ajax({
        url:'/babySex/ovulationCalc/',
        data:$('#ovulation-form').serialize(),
        type:'POST',
        success:function (data) {
            $('#result').html(data);
            $('html,body').animate({scrollTop:$('#result .calendar_body').offset().top}, 'fast');
        }
    });
}

$(function () {
    $('body').delegate('a#next-month', 'click', function () {
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

    $('body').delegate('a#prev-month', 'click', function () {
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
});
