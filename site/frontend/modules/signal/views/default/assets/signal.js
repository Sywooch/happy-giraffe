/**
 * User: alexk984
 * Date: 21.03.12
 * Time: 16:31
 */

$(function() {
    $('.nav li a').click(function () {
        Signal.Navigate($(this));
        return false;
    });
});
soundManager.url = '/swf/';

var Signal = {
    filter:null,
    year:null,
    month:null,
    current_date:null,

    removeUrl:null,

    TYPE_SIGNAL_UPDATE:null,
    TYPE_SIGNAL_EXECUTED:null,

    TakeSignal:function (elem) {
        var id = elem.prev().val();
        $.ajax({
            url:'/signal/take/',
            data:{id:id},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status == 1) {
                    var id = elem.prev().val();
                    elem.hide();
                    elem.next().show();

                } else {
                    this.UpdateSignalData();
                }
            },
            context:elem
        });
        return false;
    },
    UpdateSignalData:function (play) {
        if (play != false)
            this.Play();

        $.ajax({
            url:'/signal/',
            type:'POST',
            data:{filter:this.filter},
            dataType:'JSON',
            success:function (response) {
                $('div.main-list').html(response.tasks);
                $('div.fast-list').html(response.history);
            }
        });
    },
    DeclineSignal:function (elem) {
        $.ajax({
            url:'/signal/decline/',
            data:{id:elem.parents('td.actions').find('input').val()},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    elem.parents('td.actions').find('div.taken').hide();
                    elem.parents('td.actions').find('a.take-task').show();
                }
            },
            context:elem
        });
        return false;
    },
    Navigate:function (elem) {
        this.filter = elem.attr('obj');
        $('.nav li').removeClass('active');
        elem.parent().addClass('active');
        this.UpdateSignalData(false);
        return false;
    },
    LoadPrevMonth:function () {
        this.month--;
        if (this.month == 0) {
            this.year--;
            this.month = 12;
        }

        $.ajax({
            url:'/signal/calendar/',
            data:{month:this.month, year:this.year, current_date:this.current_date},
            type:'POST',
            success:function (response) {
                $('div.fast-calendar').html(response);
            }
        });
    },
    LoadNextMonth:function () {
        this.month++;
        if (this.month == 13) {
            this.year++;
            this.month = 1;
        }

        $.ajax({
            url:'/signal/calendar/',
            data:{month:this.month, year:this.year, current_date:this.current_date},
            type:'POST',
            success:function (response) {
                $('div.fast-calendar').html(response);
            }
        });
    },
    LoadHistory:function (elem) {
        this.current_date = this.year.toString() + '-' + this.AddZero(this.month) + '-' + this.AddZero(elem.text());

        $.ajax({
            url:'/signal/history/',
            data:{date:this.current_date},
            type:'POST',
            success:function (response) {
                $('.fast-list').html(response);
                $('.fast-calendar tbody td').removeClass('active');
                elem.parent().addClass('active');
            },
            context:elem
        });
    },
    AddZero:function (num) {
        num = parseInt(num);
        if (num < 10)
            return '0' + num.toString();
        else
            return num.toString();
    },
    Play:function (play) {
        if ($('#play_sound').attr("checked") != 'checked')
            return;
        soundManager.createSound({id:'s', url:'/audio/1.mp3'});
        soundManager.play('s');
    },
    removeHistory:function () {
        $.ajax({
            url:'/signal/removeAll/',
            type:'POST'
        });
    }
}

$(function () {
    $('.nav li a').click(function () {
        Signal.Navigate($(this));
    });
    $('body').delegate('.fast-calendar tbody a', 'click', function () {
        Signal.LoadHistory($(this));
        return false;
    });
});

Comet.prototype.UpdateTable = function (result, id) {
    console.log('update signal');
    Signal.UpdateSignalData(result.sound);
}

Comet.prototype.TaskExecuted = function (result, id) {
    Signal.UpdateSignalData();
}
