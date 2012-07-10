$(function () {
    $('body').delegate('#japan-prev-month', 'click', function () {
        var month = $('#japan_review_month').val();
        month--;
        if (month == 0) {
            month = 12;
        }
        $('#japan_review_month').val(month);
        $.ajax({
            url:'/babySex/japanCalc/',
            data:$('#japan-form').serialize(),
            type:'POST',
            success:function (data) {
                ShowResult(data);
            }
        });
        return false;
    });

    $('body').delegate('#japan-next-month', 'click', function () {
        var month = $('#japan_review_month').val();
        month++;
        if (month == 13) {
            month = 1;
        }
        $('#japan_review_month').val(month);
        $.ajax({
            url:'/babySex/japanCalc/',
            data:$('#japan-form').serialize(),
            type:'POST',
            success:function (data) {
                ShowResult(data);
            }
        });
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

function StartCalc() {
    $('#japan_review_month').val($('#JapanCalendarForm_baby_m').val());
    $.ajax({
        url:'/babySex/japanCalc/',
        data:$('#japan-form').serialize(),
        type:'POST',
        success:function (data) {
            ShowResult(data);
        }
    });
    return false;
}

function ShowResult(data) {
    $('#japan-result').html(data);
    $('html,body').animate({scrollTop:$('#japan-result').offset().top}, 'fast');
}