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
<?php $letter = (isset($_GET['letter']) && !empty($_GET['letter']))?$_GET['letter']:null;  ?>
<ul class="letters">
    <li<?php if (empty($letter)) echo ' class="active"' ?>><a href="#">Все</a></li>
    <li<?php if ($letter == 'А') echo ' class="active"' ?>><a href="#">А</a></li>
    <li<?php if ($letter == 'Б') echo ' class="active"' ?>><a href="#">Б</a></li>
    <li<?php if ($letter == 'В') echo ' class="active"' ?>><a href="#">В</a></li>
    <li<?php if ($letter == 'Г') echo ' class="active"' ?>><a href="#">Г</a></li>
    <li<?php if ($letter == 'Д') echo ' class="active"' ?>><a href="#">Д</a></li>
    <li<?php if ($letter == 'Е') echo ' class="active"' ?>><a href="#">Е</a></li>
    <li<?php if ($letter == 'Ж') echo ' class="active"' ?>><a href="#">Ж</a></li>
    <li<?php if ($letter == 'З') echo ' class="active"' ?>><a href="#">З</a></li>
    <li<?php if ($letter == 'И') echo ' class="active"' ?>><a href="#">И</a></li>
    <li<?php if ($letter == 'К') echo ' class="active"' ?>><a href="#">К</a></li>
    <li<?php if ($letter == 'Л') echo ' class="active"' ?>><a href="#">Л</a></li>
    <li<?php if ($letter == 'М') echo ' class="active"' ?>><a href="#">М</a></li>
    <li<?php if ($letter == 'Н') echo ' class="active"' ?>><a href="#">Н</a></li>
    <li<?php if ($letter == 'О') echo ' class="active"' ?>><a href="#">О</a></li>
    <li<?php if ($letter == 'П') echo ' class="active"' ?>><a href="#">П</a></li>
    <li<?php if ($letter == 'Р') echo ' class="active"' ?>><a href="#">Р</a></li>
    <li<?php if ($letter == 'С') echo ' class="active"' ?>><a href="#">С</a></li>
    <li<?php if ($letter == 'Т') echo ' class="active"' ?>><a href="#">Т</a></li>
    <li<?php if ($letter == 'У') echo ' class="active"' ?>><a href="#">У</a></li>
    <li<?php if ($letter == 'Ф') echo ' class="active"' ?>><a href="#">Ф</a></li>
    <li<?php if ($letter == 'Х') echo ' class="active"' ?>><a href="#">Х</a></li>
    <li<?php if ($letter == 'Ц') echo ' class="active"' ?>><a href="#">Ц</a></li>
    <li<?php if ($letter == 'Ч') echo ' class="active"' ?>><a href="#">Ч</a></li>
    <li<?php if ($letter == 'Э') echo ' class="active"' ?>><a href="#">Э</a></li>
    <li<?php if ($letter == 'Ю') echo ' class="active"' ?>><a href="#">Ю</a></li>
    <li<?php if ($letter == 'Я') echo ' class="active"' ?>><a href="#">Я</a></li>
</ul>
<div class="content_block">
    <?php $this->renderPartial('_gender'); ?>

    <?php if (!empty($letter)):?>
        <p class="names_header">Имена на букву <span><?php echo $letter ?></span></p>
    <?php else: ?>
        <p class="names_header">Все имена</p>
    <?php endif ?>

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