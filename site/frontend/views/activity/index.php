<?php
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/javascripts/jquery.jcarousel.js');
?>

<script>
    $(function(){

        $('#activity-photo').jcarousel({wrap: 'circular'});

    })
</script>

<div id="activity">

    <div class="content-title">Что у нас новенького?</div>

    <div class="content-cols clearfix">

        <div class="col-1">

            <?php $this->widget('LiveWidget'); ?>

            <?php $this->widget('WantToChatWidget'); ?>

            <!--<div class="banner">
                <a href=""><img src="/images/banner_04.png"></a>
            </div>-->

        </div>

        <div class="col-23">

            <div class="clearfix">

                <div class="col-2">

                    <?php $this->widget('VideoWidget'); ?>

                    <?php $this->widget('FriendsWidget'); ?>

                    <?php $this->widget('RandomPhotosWidget'); ?>

                    <?php $this->widget('DuelWidget'); ?>

                    <?php $this->widget('HumorWidget'); ?>

                </div>

                <div class="col-3">

                    <?php $this->widget('TopFiveWidget'); ?>
                    <?php $this->widget('BlogPopularWidget'); ?>
                    <?php $this->widget('CommunityPopularWidget'); ?>

                </div>

            </div>

        </div>

    </div>

</div>