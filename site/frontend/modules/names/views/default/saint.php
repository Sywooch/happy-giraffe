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
        $('ul.choice_month a').click(function () {
            month = $(this).attr('rel');

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/SaintCalc") ?>',
                data:{
                    month:month,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('ul.choice_alfa_letter li').removeClass('current');
                    $(this).parent('li').addClass('current');
                    $('#result').html(data);
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
                    $('.gender-link li').removeClass('current');
                    $(this).parent('li').addClass('current');
                    $('#result').html(data);
                },
                context:$(this)
            });
            return false;
        });
    });
</script>

<ul class="choice_month">
    <li class="current"><a href="#" rel="1">Январь</a></li>
    <li><a href="#" rel="2">Февраль</a></li>
    <li><a href="#" rel="3">Март</a></li>
</ul>

<div class="show_names">
    <span class="show_wh">Показывать:</span>
    <ul class="gender-link">
        <li class="all_names current">
            <a href="#" rel="">
                <img src="/images/all_names_icon.png" alt="" title="" /><br />
                <span>Все имена</span>
            </a>
        </li>
        <li class="man_names">
            <a href="#" rel="1">
                <img src="/images/man_names_icon.png" alt="" title="" /><br />
                <span>Мальчики</span>
            </a>
        </li>
        <li class="woman_names">
            <a href="#" rel="2">
                <img src="/images/women_names_icon.png" alt="" title="" /><br />
                <span>Девочки</span>
            </a>
        </li>
    </ul>
    <div class="clear"></div><!-- .clear -->
</div><!-- .show_names -->
<div class="clear"></div><!-- .clear -->

<div id="result">

</div>