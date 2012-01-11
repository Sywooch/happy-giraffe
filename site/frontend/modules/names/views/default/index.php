<script type="text/javascript">
    var gender;
    var letter;
    var page;

    $(function () {

        $('ul.choice_alfa_letter a').click(function () {
            letter = $(this).text();

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/index") ?>',
                data:{
                    letter:letter,
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
                url:'<?php echo Yii::app()->createUrl("/names/default/index") ?>',
                data:{
                    letter:letter,
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

        $('body').delegate('.pagination a', 'click', function(){
            $.ajax({
                url:$(this).attr('href'),
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('#result').html(data);
                }
            });

            return false;
        });
    });
</script>
<ul class="choice_alfa_letter">
    <li class="current"><a href="#">Все</a></li>
    <li><a href="#">А</a></li>
    <li><a href="#">Б</a></li>
    <li><a href="#">В</a></li>
    <li><a href="#">Г</a></li>
    <li><a href="#">Д</a></li>
    <li><a href="#">Е</a></li>
    <li><a href="#">Ж</a></li>
    <li><a href="#">З</a></li>
    <li><a href="#">И</a></li>
    <li><a href="#">К</a></li>
    <li><a href="#">Л</a></li>
    <li><a href="#">М</a></li>
    <li><a href="#">Н</a></li>
    <li><a href="#">О</a></li>
    <li><a href="#">П</a></li>
    <li><a href="#">Р</a></li>
    <li><a href="#">С</a></li>
    <li><a href="#">Т</a></li>
    <li><a href="#">У</a></li>
    <li><a href="#">Ф</a></li>
    <li><a href="#">Х</a></li>
    <li><a href="#">Ц</a></li>
    <li><a href="#">Ч</a></li>
    <li><a href="#">Э</a></li>
    <li><a href="#">Ю</a></li>
    <li><a href="#">Я</a></li>
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
    <?php
    $this->renderPartial('index_data', array(
        'names' => $names,
        'pages' => $pages,
        'like_ids'=>$like_ids
    )); ?>
</div>