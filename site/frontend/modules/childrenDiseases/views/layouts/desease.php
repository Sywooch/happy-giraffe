<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerScript('chilred-dizzy-2', "
        $('#disease-alphabet').mouseover(function () {
            if ($(this).parent('li').hasClass('current_t')) {
                $('#popup').hide();
                $(this).parent('li').removeClass('current_t');
            } else{
                $('#disease-type').parent('li').removeClass('current_t');
                $.ajax({
                    url:'" . Yii::app()->createUrl("/childrenDiseases/default/getAlphabetList") . "',
                    type:'POST',
                    success:function (data) {
                        $('#popup').html(data);
                        $('#popup').show();
                        $(this).parent('li').addClass('current_t');
                        timer = setTimeout('popupOff()', 1000);
                        current_link = 'alphabet';
                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('#disease-type').mouseover(function () {
            if ($(this).parent('li').hasClass('current_t')) {
                $('#popup').hide();
                $(this).parent('li').removeClass('current_t');
            } else{
                $('#disease-alphabet').parent('li').removeClass('current_t');
                $.ajax({
                    url:'" . Yii::app()->createUrl("/childrenDiseases/default/getCategoryList") . "',
                    type:'POST',
                    success:function (data) {
                        $('#popup').html(data);
                        $('#popup').show();
                        $(this).parent('li').addClass('current_t');
                        timer = setTimeout('popupOff()', 1000);
                        current_link = 'type';
                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('#popup').mouseover(function(){
            if (timer != null)
                clearTimeout(timer);
            in_block = true;
        });

        $('#popup').mouseout(function(){
            if (timer != null)
                clearTimeout(timer);
            in_block = false;
        });

        $('#disease-alphabet').mouseout(function(){
            if (current_link == 'alphabet'){
                if (timer != null)
                    clearTimeout(timer);
                in_link = false;
            }
        });

        $('#disease-alphabet').mouseover(function(){
            if (current_link == 'alphabet'){
                if (timer != null)
                clearTimeout(timer);
                in_link = true;
            }
        });

        $('#disease-type').mouseout(function(){
            if (current_link == 'type'){
                if (timer != null)
                clearTimeout(timer);
                in_link = false;
            }
        });

        $('#disease-type').mouseover(function(){
            if (current_link == 'type'){
                if (timer != null)
                clearTimeout(timer);
                in_link = true;
            }
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

"); ?>
<script type="text/javascript">
    var timer;
    var in_block = false;
    var in_link = false;
    var current_link = null;

    function popupOff(){
        if (!in_block && !in_link){
            $('#popup').hide();
            $('#disease-alphabet').parent('li').removeClass('current_t');
            $('#disease-type').parent('li').removeClass('current_t');
            timer = null;
        }
    }
</script>
<div id="baby">

    <div class="content-box clearfix">
        <div class="baby_handbook_service">
            <ul class="handbook_changes_u">
                <li<?php if (Yii::app()->controller->index == true) echo ' class="current_t"' ?>><a href="<?php echo $this->createUrl('/childrenDiseases/default/index') ?>">Главная</a>
                </li>
                <li><a id="disease-alphabet" href="#"><span>Болезни по алфавиту</span></a></li>
                <li><a id="disease-type" href="#"><span>Болезни по типу</span></a></li>
            </ul>
            <div class="handbook_alfa_popup" id="popup" style="display: none;">

            </div>
        </div>
        <div class="clear"></div>
        <!-- .clear -->
        <!-- .baby_recipes_service -->

        <?php echo $content ?>
    </div>

</div>
<div class="push"></div>
<?php $this->endContent(); ?>