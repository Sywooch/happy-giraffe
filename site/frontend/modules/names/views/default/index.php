<script type="text/javascript">
    var gender;
    var letter;
    var page;

    $(function () {

        $('ul.letters a').click(function () {
            letter = $(this).text();

            $.ajax({
                url:'<?php echo Yii::app()->createUrl("/names/default/index") ?>',
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('ul.letters li').removeClass('active');
                    if ($(this).text() == 'Все')
                        $('p.names_header').html('Все имена');
                    else
                        $('p.names_header').html('Имена на букву <span>'+$(this).text()+'</span>');
                    $(this).parent('li').addClass('active');
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
                    $('.gender-link a').removeClass('active');
                    $(this).addClass('active');
                    $('#result').html(data);
                },
                context:$(this)
            });
            return false;
        });

        $('body').delegate('.pagination a', 'click', function () {
            $.ajax({
                url:$(this).attr('href'),
                data:{
                    letter:letter,
                    gender:gender
                },
                type:'GET',
                success:function (data) {
                    $('#result').html(data);
                    $('html,body').animate({scrollTop: $('ul.letters').offset().top},'fast');
                }
            });

            return false;
        });
    });
</script>
<ul class="letters">
    <li class="active"><a href="#">Все</a></li>
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
<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>
    <p class="names_header">Все имена</p>

    <div class="clear"></div>

    <div id="result" class="list_names">
        <?php
        $this->renderPartial('index_data', array(
            'names' => $names,
            'pages' => $pages,
            'like_ids' => $like_ids
        )); ?>
    </div>
</div>