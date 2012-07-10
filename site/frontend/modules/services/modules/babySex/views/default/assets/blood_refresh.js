$('body').delegate('#blood-refresh-prev-month', 'click', function () {
    var month = $('#blood_refr_review_month').val();
    var year = $('#blood_refr_review_year').val();
    month--;
    if (month == 0) {
        month = 12;
        year--;
        $('#blood_refr_review_year').val(year);
    }
    $('#blood_refr_review_month').val(month);
    $.ajax({
        url:$('#blood-refresh-form').attr('action'),
        data:$('#blood-refresh-form').serialize(),
        type:'POST',
        success:function (data) {
            ShowResult(data);
        }
    });
    return false;
});

$('body').delegate('#blood-refresh-next-month', 'click', function () {
    var month = $('#blood_refr_review_month').val();
    var year = $('#blood_refr_review_year').val();
    month++;
    if (month == 13) {
        month = 1;
        year++;
        $('#blood_refr_review_year').val(year);
    }
    $('#blood_refr_review_month').val(month);
    $.ajax({
        url:$('#blood-refresh-form').attr('action'),
        data:$('#blood-refresh-form').serialize(),
        type:'POST',
        success:function (data) {
            ShowResult(data);
        }
    });
    return false;
});

function StartCalc() {
    $('#blood_refr_review_year').val($('#BloodRefreshForm_baby_y').val());
    $('#blood_refr_review_month').val($('#BloodRefreshForm_baby_m').val());
    $.ajax({
        url:'/babySex/bloodUpdate/',
        data:$('#blood-refresh-form').serialize(),
        type:'POST',
        success:function (data) {
            ShowResult(data);
        }
    });
}

function ShowResult(data) {
    $('#blood-update-result').html(data);
    $('html,body').animate({scrollTop:$('#blood-update-result').offset().top}, 'fast');
}

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