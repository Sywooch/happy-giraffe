<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerScript('chilred-dizzy-2', "
        $('#disease-alphabet').click(function () {
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
                    },
                    context:$(this)
                });
            }
            return false;
        });

        $('#disease-type').click(function () {
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
                    },
                    context:$(this)
                });
            }
            return false;
        });
    "); ?>
<div id="baby">

    <div class="content-box clearfix">
        <div class="baby_handbook_service">
            <ul class="handbook_changes_u">
                <li class="current_t"><a href="<?php echo $this->createUrl('/childrenDiseases/default/index') ?>">Главная</a>
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