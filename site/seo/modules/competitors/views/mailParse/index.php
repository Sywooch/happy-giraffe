<?php
Yii::app()->clientScript->registerScriptFile('http://www.happy-giraffe.ru/javascripts/soundmanager2.js');

?>
<div class="form">

    <div class="row">
        <?php echo CHtml::label('Выберите сайт', 'site');
        echo CHtml::dropDownList('site_id', '', CHtml::listData(Site::model()->findAll(), 'id', 'name'), array('id' => 'site')) . '<br>'; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Выберите сайт', 'site');
        echo CHtml::dropDownList('year', 2012, array(2012 => 2012, 2011 => 2011), array('id' => 'year')) . '<br>';?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Выберите месяц с которого парсить', 'site');
        echo CHtml::textField('month_from', 1, array('id' => 'month_from')) . '<br>'; ?>
    </div>
    <div class="row">
        <?php echo CHtml::label('Выберите месяц до которого парсить', 'site');
        echo CHtml::textField('month_to', 5, array('id' => 'month_to')) . '<br>'; ?>
    </div>

    <?php echo CHtml::link('Парсить сайт', '#', array('onclick' => 'Competitors.Parse(1)')); ?>
    <br>
    <?php echo CHtml::link('посмотреть страницу', '#', array('onclick' => 'Competitors.Parse(2)')); ?>
    <br>

    <br><br>
    <a href="javascript:;" onclick="Competitors.Play()">Play</a>
</div>

<script type="text/javascript">
    soundManager.url = '/swf/';

    var Competitors = {
        Parse:function (mode) {
            $.post('/competitors/mailParse/parse/', {
                site_id:$('#site').val(),
                year:$('#year').val(),
                month_from:$('#month_from').val(),
                month_to:$('#month_to').val(),
                mode:mode
            }, function (response) {
                if (response.status)
                    $.pnotify({
                        pnotify_title:'Успешно',
                        pnotify_text:response.count + ' новых запросов спарсили',
                        pnotify_hide:false
                    });
                else
                    $.pnotify({
                        pnotify_title:'Ошибка',
                        pnotify_type:'error',
                        pnotify_text:response.error
                    });
                Competitors.Play();
            }, 'json');
        },
        Play:function () {
            soundManager.createSound({id:'s', url:'/audio/1.mp3'});
            soundManager.play('s');
        }
    }
</script>