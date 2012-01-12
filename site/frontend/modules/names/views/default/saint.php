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

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/SaintCalc") ?>',
                data:{
                    month:month,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('ul.letters li').removeClass('active');
                    $(this).parent('li').addClass('active');
                    $('#result').html(data);
                    $('p.names_header').html('Имена по святцам - <span>' + $(this).text() + '</span>');
                },
                context:$(this)
            });
            return false;
        });

        $('.gender-link a').click(function () {
            gender = $(this).attr('rel');

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/SaintCalc") ?>',
                data:{
                    month:month,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('.gender-link a').removeClass('active');
                    $(this).addClass('active');
                    $('#result').html(data);
                },
                context:$(this)
            });
            return false;
        });
    });
</script>

<ul class="letters month">
    <li><a href="#">Январь</a></li>
    <li><a href="#">Февраль</a></li>
    <li><a href="#">Март</a></li>
    <li><a href="#">Апрель</a></li>
    <li><a href="#">Май</a></li>
    <li><a href="#">Июнь</a></li>
    <li><a href="#">Июль</a></li>
    <li><a href="#">Август</a></li>
    <li><a href="#">Сентябрь</a></li>
    <li><a href="#">Октябрь</a></li>
    <li><a href="#">Ноябрь</a></li>
    <li><a href="#">Декабрь</a></li>
</ul>

<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>
    <p class="names_header calendar">Имена по святцам</p>
    <div class="clear"></div>

    <div id="result">

    </div>
</div>