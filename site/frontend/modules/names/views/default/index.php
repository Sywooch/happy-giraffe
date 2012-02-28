<script type="text/javascript">
    var gender;
    var letter = <?php echo (empty($letter))?'null':"'".$letter."'" ?>;
    var page;

    $(function () {

        $('ul.letters a').click(function () {
            letter = $(this).text();

            if (typeof(window.history.pushState) == 'function'){
                window.history.pushState(
                    { path: $(this).attr('href'), letter:letter },
                    'Имена на букву '+letter,
                    $(this).attr('href')
                );
            } else {
                return true;
            }

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

        $(window).bind('popstate', function(event) {
            var state = event.originalEvent.state;
            if (state) {
                $.ajax({
                    url:state.path,
                    type:'GET',
                    data:{gender:gender},
                    success:function (data) {
                        $('ul.letters li').removeClass('active');

                        if (state.letter == null){
                            $('p.names_header').html('Все имена');
                            $('ul.letters li:first').addClass('active');
                            letter = null;
                        }
                        else{
                            $('p.names_header').html('Имена на букву <span>'+state.letter+'</span>');
                            letter = state.letter;
                        }
                        $('ul.letters li').each(function(index, value){
                            if ($(this).text() == state.letter)
                                $(this).addClass('active');
                        });
                        $('#result').html(data);
                    },
                    context:$(this)
                });
            }
        });

        history.replaceState({ path: window.location.href, letter:letter }, '');
    });
</script>
<ul class="letters">
    <li<?php if (empty($letter)) echo ' class="active"' ?>><a href="#">Все</a></li>
    <li<?php if ($letter == 'А') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'А')) ?>">А</a></li>
    <li<?php if ($letter == 'Б') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Б')) ?>">Б</a></li>
    <li<?php if ($letter == 'В') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'В')) ?>">В</a></li>
    <li<?php if ($letter == 'Г') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Г')) ?>">Г</a></li>
    <li<?php if ($letter == 'Д') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Д')) ?>">Д</a></li>
    <li<?php if ($letter == 'Е') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Е')) ?>">Е</a></li>
    <li<?php if ($letter == 'Ж') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Ж')) ?>">Ж</a></li>
    <li<?php if ($letter == 'З') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'З')) ?>">З</a></li>
    <li<?php if ($letter == 'И') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'И')) ?>">И</a></li>
    <li<?php if ($letter == 'К') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'К')) ?>">К</a></li>
    <li<?php if ($letter == 'Л') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Л')) ?>">Л</a></li>
    <li<?php if ($letter == 'М') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'М')) ?>">М</a></li>
    <li<?php if ($letter == 'Н') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Н')) ?>">Н</a></li>
    <li<?php if ($letter == 'О') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'О')) ?>">О</a></li>
    <li<?php if ($letter == 'П') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'П')) ?>">П</a></li>
    <li<?php if ($letter == 'Р') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Р')) ?>">Р</a></li>
    <li<?php if ($letter == 'С') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'С')) ?>">С</a></li>
    <li<?php if ($letter == 'Т') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Т')) ?>">Т</a></li>
    <li<?php if ($letter == 'У') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'У')) ?>">У</a></li>
    <li<?php if ($letter == 'Ф') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Ф')) ?>">Ф</a></li>
    <li<?php if ($letter == 'Х') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Х')) ?>">Х</a></li>
    <li<?php if ($letter == 'Ц') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Ц')) ?>">Ц</a></li>
    <li<?php if ($letter == 'Ч') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Ч')) ?>">Ч</a></li>
    <li<?php if ($letter == 'Э') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Э')) ?>">Э</a></li>
    <li<?php if ($letter == 'Ю') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Ю')) ?>">Ю</a></li>
    <li<?php if ($letter == 'Я') echo ' class="active"' ?>><a href="<?php echo $this->createUrl('/names/default/index', array('letter'=>'Я')) ?>">Я</a></li>
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