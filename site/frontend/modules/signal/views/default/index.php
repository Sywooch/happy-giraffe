<?php
/* @var $this CController
 * @var $models UserSignal[]
 * @var $history UserSignal[]
 */

Yii::app()->clientScript->registerScriptFile('/javascripts/soundmanager2.js');
?>
<div class="fast-calendar">
    <?php $this->renderPartial('_calendar', array(
    'month' => date("n"),
    'year' => date("Y"),
    'activeDate' => date("Y-m-d"),
)); ?>
</div>
<div class="title"><i class="icon"></i>Сигналы</div>

<div class="username">
    <i class="icon-status status-online"></i><span><?= User::getUserById(Yii::app()->user->id)->getFullName() ?></span>
</div>

<div class="nav">
    <ul>
        <li class="active"><a href="" obj="">Все</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_POST ?>">Посты</a></li>
        <!--        <li><a href="" obj="--><?php //echo UserSignal::TYPE_NEW_USER_POST ?><!--">Клубы</a></li>-->
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_VIDEO ?>">Видео</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_BLOG_POST ?>">Блоги</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_PHOTO ?>">Фото</a></li>
        <li><a href="" obj="<?php echo UserSignal::TYPE_NEW_USER_REGISTER ?>">Гостевые</a></li>
    </ul>
</div>

<div class="clear"></div>
<input type="checkbox" id="play_sound" checked /> <label for="play_sound">Проигрывать звук</label>
<?php if (Yii::app()->user->id == 10):?>
<br><a href="#" onclick="removeHistory()">Очистить всё</a>
<?php endif ?>

<div class="main-list">
    <?php $this->renderPartial('_data', array('models' => $models)); ?>
</div>

<div class="fast-list">
    <?php $this->renderPartial('_history', array('history' => $history)); ?>
</div>

<!--<a href="#" onclick="Play();">play</a>-->

<script type="text/javascript">
    var filter = null;
    var year = <?php echo date('Y') ?>;
    var month = <?php echo date('n') ?>;
    var current_date = '<?php echo date("Y-m-d")  ?>';

    soundManager.url = '/swf/soundmanager2.swf';

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

        comet.addEvent(<?php echo CometModel::TYPE_SIGNAL_UPDATE ?>, 'UpdateTable');
        comet.addEvent(<?php echo CometModel::TYPE_SIGNAL_EXECUTED ?>, 'TaskExecuted');
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

    function Play(){
        if ($('#play_sound').attr("checked") != 'checked')
            return ;
        // создание объекта "звук"
        soundManager.createSound('myNewSound','/audio/notify.wav');

        // установка громкости и воспроизведение
        soundManager.play('myNewSound');
        soundManager.setVolume('myNewSound',50);
        soundManager.setPan('myNewSound',-100);;
    }

    function removeHistory(){
        $.ajax({
            url:'<?php echo Yii::app()->createUrl("/signal/default/removeAll") ?>',
            type:'POST'
        });
    }
</script>