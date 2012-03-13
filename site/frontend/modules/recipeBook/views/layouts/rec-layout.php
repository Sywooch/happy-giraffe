<?php $this->beginContent('//layouts/main'); ?>
<?php
    $cs = Yii::app()->clientScript;

    $js = "
        $('#disease-alphabet').mouseover(function () {
            if ($(this).parent('li').hasClass('current_t')) {
                still_out = false;
            } else{
            $(this).parent('li').addClass('current_t');
                        $('#disease-type').parent('li').removeClass('current_t');

                $.ajax({
                    url:'" . Yii::app()->createUrl("/recipeBook/default/getAlphabetList") . "',
                    type:'POST',
                    success:function (data) {
                        $('#popup').html(data);
                        $('#popup').show();

                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('#disease-type').mouseover(function () {
            if ($(this).parent('li').hasClass('current_t')) {
                still_out = false;
            } else{
                $(this).parent('li').addClass('current_t');
                        $('#disease-alphabet').parent('li').removeClass('current_t');
                $.ajax({
                    url:'" . Yii::app()->createUrl("/recipeBook/default/getCategoryList") . "',
                    type:'POST',
                    success:function (data) {
                        $('#popup').html(data);
                        $('#popup').show();

                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('html').click(function(){
            $('#popup').hide();
            $('#disease-alphabet').parent('li').removeClass('current_t');
            $('#disease-type').parent('li').removeClass('current_t');
        });

        $('#popup').click(function(event){
            event.stopPropagation();
        });
        $('#popup').click(function(event){
            event.stopPropagation();
        });

        var still_out = true;
        var closetimer;

        $('#popup').bind('mouseleave', function(){
            still_out = true;
            closetimer = window.setTimeout(popup_close, 500);
        });

        $('#popup').bind('mouseover', function(){
            still_out = false;
        });

        $('#disease-alphabet').bind('mouseleave',  function(){
            if ($(this).parent('li').hasClass('current_t')){
                still_out = true;
                closetimer = window.setTimeout(popup_close, 500);
            }
        });
        $('#disease-type').bind('mouseleave',  function(){
            if ($(this).parent('li').hasClass('current_t')){
                still_out = true;
                closetimer = window.setTimeout(popup_close, 500);
            }
        });

        function popup_close(){
            if (still_out){
                $('#popup').hide();
                $('#disease-alphabet').parent('li').removeClass('current_t');
                $('#disease-type').parent('li').removeClass('current_t');
                clearTimeout(closetimer);
            }
        }
    ";

    $cs
        ->registerScript('chilred-dizzy-2', $js)
        ->registerCssFile('/stylesheets/global.css')
        ->registerCssFile('/stylesheets/baby.css')
    ;
?>
<div id="baby">
    <div class="inner">
    <div class="content-box clearfix">
        <div class="baby_recipes_service">
            <ul class="handbook_changes_u">
                <li<?php if (Yii::app()->controller->index == true) echo ' class="current_t"' ?>><a href="<?php echo $this->createUrl('/recipeBook/default/index') ?>">Главная</a>
                </li>
                <li><a id="disease-alphabet" href="#"><span>Болезни по алфавиту</span></a></li>
                <li><a id="disease-type" href="#"><span>Болезни по типу</span></a></li>
            </ul>
            <div class="handbook_alfa_popup" id="popup" style="display: none;">

            </div>
        </div>
    </div>
    <?php echo $content ?>
    </div>
</div>
<?php $this->endContent(); ?>