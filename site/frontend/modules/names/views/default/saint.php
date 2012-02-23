<?php
/* @var $this Controller
 * @var $form CActiveForm
 * @var $model Name
 */
?>
<script type="text/javascript">
    var gender;
    var month;

    $(function () {
        $('ul.letters a').click(function () {
            month = $('ul.month li a').index($(this)) + 1;

            if (typeof(window.history.pushState) == 'function'){
                window.history.pushState({ path: $(this).attr('href') },'Святцы в '+$(this).text(),
                    $(this).attr('href'));
            } else {
                return true;
            }

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/saint") ?>',
                data:{
                    m:month,
                    gender:gender
                },
                type:'GET',
                dataType:'JSON',
                success:function (data) {
                    $('ul.letters li').removeClass('active');
                    $(this).parent('li').addClass('active');
                    $('#result').html(data.html);
                    $('p.names_header').html('Имена по святцам - <span>' + data.month + '</span>');
                },
                context:$(this)
            });
            return false;
        });

        $('.gender-link a').click(function () {
            gender = $(this).attr('rel');

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/saint") ?>',
                data:{
                    m:month,
                    gender:gender
                },
                type:'GET',
                dataType:'JSON',
                success:function (data) {
                    $('.gender-link a').removeClass('active');
                    $(this).addClass('active');
                    $('#result').html(data.html);
                },
                context:$(this)
            });
            return false;
        });

        $(window).bind('popstate', function(event) {
            var state = event.originalEvent.state;
            if (state) {
                gender = $(this).attr('rel');
                $.ajax({
                    url:state.path,
                    type:'GET',
                    dataType:'JSON',
                    success:function (data) {
                        $('.gender-link a').removeClass('active');
                        $('.all_names').addClass('active');
                        $('#result').html(data.html);
                        $('ul.letters li').removeClass('active');
                        if (data.month == null){
                            $('p.names_header').html('Имена по святцам');
                        }else{
                            $('p.names_header').html('Имена по святцам - <span>' + data.month + '</span>');
                            $('ul.letters li:eq('+(data.month_num-1)+')').addClass('active');
                        }
                        month = data.month_num;
                    },
                    context:$(this)
                });
            }
        });

        history.replaceState({ path: window.location.href }, '');
    });
</script>

<ul class="letters month">
    <li<?php if ($month == 1) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'january')) ?>">Январь</a></li>
    <li<?php if ($month == 2) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'february')) ?>">Февраль</a></li>
    <li<?php if ($month == 3) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'march')) ?>">Март</a></li>
    <li<?php if ($month == 4) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'april')) ?>">Апрель</a></li>
    <li<?php if ($month == 5) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'may')) ?>">Май</a></li>
    <li<?php if ($month == 6) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'june')) ?>">Июнь</a></li>
    <li<?php if ($month == 7) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'july')) ?>">Июль</a></li>
    <li<?php if ($month == 8) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'august')) ?>">Август</a></li>
    <li<?php if ($month == 9) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'september')) ?>">Сентябрь</a></li>
    <li<?php if ($month == 10) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'october')) ?>">Октябрь</a></li>
    <li<?php if ($month == 11) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'november')) ?>">Ноябрь</a></li>
    <li<?php if ($month == 12) echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/saint', array('m'=>'december')) ?>">Декабрь</a></li>
</ul>

<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>
    <p class="names_header calendar">Имена по святцам<?php if (!empty($month)) echo ' - <span>' . HDate::ruMonth($month). '</span>'; ?></p>
    <div class="clear"></div>

    <div id="result">
        <?php if ($month !== null):?>
        <?php $this->renderPartial('saint_res',array(
            'month'=>$month,
            'data' => $data,
            'like_ids' => $like_ids
        )); ?>
        <?php endif ?>
    </div>
</div>