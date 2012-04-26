var arr = new Array(
    new Array(2, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1),
    new Array(1, 2, 1, 2, 2, 1, 1, 2, 1, 1, 2, 2),
    new Array(2, 1, 2, 1, 1, 1, 1, 1, 1, 2, 1, 1),
    new Array(1, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2),
    new Array(2, 1, 1, 2, 1, 2, 2, 1, 2, 2, 2, 2),
    new Array(1, 1, 1, 2, 1, 1, 2, 2, 2, 1, 1, 2),
    new Array(1, 2, 2, 1, 1, 2, 1, 2, 1, 1, 2, 1),
    new Array(2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 1, 1),
    new Array(1, 1, 1, 1, 1, 2, 1, 2, 2, 1, 2, 2),
    new Array(2, 2, 1, 1, 2, 1, 2, 2, 1, 2, 1, 1),
    new Array(1, 1, 1, 2, 2, 1, 2, 1, 2, 2, 1, 2),
    new Array(2, 1, 2, 2, 1, 2, 2, 1, 2, 1, 2, 2),
    new Array(1, 1, 2, 1, 2, 1, 1, 1, 1, 1, 1, 1),
    new Array(1, 1, 1, 1, 2, 2, 1, 2, 1, 2, 2, 2),
    new Array(1, 2, 2, 1, 2, 1, 1, 2, 1, 1, 2, 1),
    new Array(2, 1, 1, 2, 2, 1, 2, 1, 2, 1, 1, 2),
    new Array(1, 1, 2, 2, 1, 2, 1, 1, 2, 1, 2, 2),
    new Array(1, 2, 1, 2, 1, 2, 1, 2, 1, 1, 2, 1),
    new Array(1, 2, 1, 1, 1, 2, 1, 1, 2, 2, 2, 2),
    new Array(2, 2, 1, 2, 2, 2, 1, 2, 2, 1, 1, 1),
    new Array(1, 1, 2, 2, 1, 2, 2, 1, 2, 2, 1, 2),
    new Array(2, 2, 1, 2, 2, 2, 1, 2, 1, 1, 2, 1),
    new Array(1, 1, 1, 2, 1, 2, 1, 2, 1, 2, 2, 1),
    new Array(2, 2, 1, 2, 1, 1, 2, 2, 1, 2, 1, 2),
    new Array(1, 2, 2, 1, 1, 1, 1, 1, 2, 1, 2, 1),
    new Array(2, 1, 2, 2, 1, 1, 1, 2, 2, 2, 1, 1),
    new Array(1, 2, 2, 2, 1, 2, 1, 1, 2, 1, 2, 1),
    new Array(2, 1, 2, 1, 2, 2, 1, 2, 1, 2, 1, 2)
);
var year = null;

$(document).ready(function () {
    var d = new Date();
    year = d.getFullYear();

    $('body').delegate('#prev', 'click', function () {
        var mother_y = $('#ChinaCalendarForm_mother_y').val();
        var age = year - mother_y - 1;
        if (age < 18 || (age == 18 && $('#ChinaCalendarForm_mother_m').val() == 12))
            return false;
        year--;
        ShowCalendar();
        if (age == 18 || (age == 19 && $('#ChinaCalendarForm_mother_m').val() == 12))
            $('#prev').addClass('disabled');

        return false;
    });

    $('body').delegate('#next', 'click', function () {
        var mother_y = $('#ChinaCalendarForm_mother_y').val();
        var age = year - mother_y;
        if (age > 45)
            return false;

        year++;
        ShowCalendar();
        if (age == 45)
            $('#next').addClass('disabled');

        return false;
    });
});

function StartCalc(){
    var d = new Date();
    var baby_y = parseInt($('#ChinaCalendarForm_baby_y').val());
    var mother_m = parseInt($('#ChinaCalendarForm_mother_m').val());
    var baby_m = parseInt($('#ChinaCalendarForm_baby_m').val());
    var mother_y = parseInt($('#ChinaCalendarForm_mother_y').val());
    year = baby_y;

    var age = baby_y - mother_y;
    if (baby_m <= mother_m)
        var age = baby_y - mother_y - 1;
    if (age < 18 || age > 45) {
        $('#china-calendar-result').html('');
        $('.wh_wait').hide();
        return false;
    }

    ShowCalendar();

    var gender = GetGenderFromAge(age, baby_m);
    $('.wh_wait').hide();
    if (gender == 1) {
        $('.wh_son').show();
    }
    if (gender == 2) {
        $('.wh_daughter').show();
    }
}

function ShowCalendar() {
    var calendar2_html = '<div class="month_calendar"><div class="choice_month">' +
        '<a href="#" id="prev" class="prev">&larr;</a>' +
        '<a href="#" id="next"  class="next">&rarr;</a>' +
        '<span>' + year + '</span>' +
        '</div><table class="calendar_body"><tr><th>Янв</th><th>Фев</th><th>Мар</th><th>Апр</th><th>Май</th>' +
        '<th>Июн</th><th>Июл</th><th>Авг</th><th>Сен</th><th>Окт</th><th>Ноя</th><th>Дек</th></tr><tr>';

    //calc mother age
    var mother_m = parseInt($('#ChinaCalendarForm_mother_m').val());
    var mother_y = parseInt($('#ChinaCalendarForm_mother_y').val());

    for (var i = 1; i <= 12; i++) {
        var age = year - mother_y;
        if (i <= mother_m)
            var age = year - mother_y - 1;

        var gender = GetGenderFromAge(age, i);
        var cell_class = '';
        if (gender == 1)
            cell_class = "cal_item boy_day";
        if (gender == 2)
            cell_class = "cal_item girl_day";
        if (year == $('#ChinaCalendarForm_baby_y').val() && i == $('#ChinaCalendarForm_baby_m').val())
            cell_class += ' active_item';

        calendar2_html += "<td><div class='" + cell_class + "'><i class='icon'></i></div></td>";
    }
    calendar2_html += '</tr></table></div>';
    $('#china-calendar-result').html(calendar2_html);
}

function GetGenderFromAge(age, month) {
    if (age - 18 < 0)
        return 0;
    if (age - 45 > 0)
        return 0;
    var result = arr[age - 18][month - 1];
    return result;
}