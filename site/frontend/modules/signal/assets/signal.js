/**
 * User: alexk984
 * Date: 21.03.12
 * Time: 16:31
 */

function UserSignals() {
    this.filter = null;
    this.year = null;
    this.month = null;
    this.current_date = null;
    soundManager.url = '/swf/';
}

$(function () {
    $('body').delegate('a.take-task', 'click', function () {
        var id = $(this).prev().val();
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("/signal/default/take") ?>',
            data:{id:id},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status == 1) {
                    var id = $(this).prev().val();
                    $(this).hide();
                    $(this).next().show();

                } else {
                    UpdateSignalData();
                }
            },
            context:$(this)
        });
        return false;
    });

    $('body').delegate('a.remove', 'click', function () {
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("/signal/default/decline") ?>',
            data:{id:$(this).parents('td.actions').find('input').val()},
            type:'POST',
            dataType:'JSON',
            success:function (response) {
                if (response.status) {
                    UpdateSignalData();
                }
            },
            context:$(this)
        });
        return false;
    });

    $('.nav li a').click(function () {
        filter = $(this).attr('obj');
        $('.nav li').removeClass('active');
        $(this).parent().addClass('active');
        UpdateSignalData();
        return false;
    });

    $('body').delegate('.fast-calendar .prev', 'click', function (e) {
        e.preventDefault();
        month--;
        if (month == 0) {
            year--;
            month = 12;
        }

        $.ajax({
            url:'<?php echo Yii::app()->createUrl("/signal/default/calendar") ?>',
            data:{month:month, year:year, current_date:current_date},
            type:'POST',
            success:function (response) {
                $('div.fast-calendar').html(response);
            },
            context:$(this)
        });
    });

    $('body').delegate('.fast-calendar .next', 'click', function (e) {
        e.preventDefault();
        month++;
        if (month == 13) {
            year++;
            month = 1;
        }

        $.ajax({
            url:'<?php echo Yii::app()->createUrl("/signal/default/calendar") ?>',
            data:{month:month, year:year, current_date:current_date},
            type:'POST',
            success:function (response) {
                $('div.fast-calendar').html(response);
            },
            context:$(this)
        });
    });

    $('body').delegate('.fast-calendar tbody a', 'click', function (e) {
        e.preventDefault();

        current_date = year.toString() + '-' + AddZero(month) + '-' + AddZero($(this).text());

        $.ajax({
            url:'<?php echo Yii::app()->createUrl("/signal/default/history") ?>',
            data:{date:current_date},
            type:'POST',
            success:function (response) {
                $('.fast-list').html(response);
                $('.fast-calendar tbody td').removeClass('active');
                $(this).parent().addClass('active');
            },
            context:$(this)
        });
    });

    comet.addEvent(TYPE_SIGNAL_UPDATE, 'UpdateTable');
    comet.addEvent(TYPE_SIGNAL_EXECUTED, 'TaskExecuted');
});

Comet.prototype.UpdateTable = function (result, id) {
    UpdateSignalData();
}

Comet.prototype.TaskExecuted = function (result, id) {
    UpdateSignalData();
}

function AddZero(num) {
    num = parseInt(num);
    if (num < 10)
        return '0' + num.toString();
    else
        return num.toString();
}

function UpdateSignalData() {
    Play();

    $.ajax({
        url:'<?php echo Yii::app()->createUrl("/signal/default/index") ?>',
        type:'POST',
        data:{filter:filter},
        dataType:'JSON',
        success:function (response) {
            $('div.main-list').html(response.tasks);
            $('div.fast-list').html(response.history);
        }
    });
}

function Play() {
    if ($('#play_sound').attr("checked") != 'checked')
        return;
    soundManager.createSound({id:'s', url:'/audio/1.mp3'});
    soundManager.play('s');
}

function removeHistory() {
    $.ajax({
        url:'<?php echo Yii::app()->createUrl("/signal/default/removeAll") ?>',
        type:'POST'
    });
}