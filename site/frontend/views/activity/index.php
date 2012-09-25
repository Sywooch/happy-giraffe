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

            <?php if ($this->beginCache('activity-page-1', array('duration' => 60))) { ?>
                <?php $this->widget('LiveWidget'); ?>

                <?php $this->widget('WantToChatWidget'); ?>
            <?php $this->endCache(); } ?>

            <?=$this->renderPartial('//_banner')?>

        </div>

        <div class="col-23">

            <div class="clearfix">

                <div class="col-2">

                    <?php if ($this->beginCache('activity-page-2', array('duration' => 60))) { ?>
                        <?php $this->widget('VideoWidget'); ?>
                    <?php $this->endCache(); } ?>

                    <?php if ($this->beginCache('activity-page-3', array('duration' => 600))) { ?>
                        <?php $this->widget('FriendsWidget'); ?>
                        <?php $this->widget('RandomPhotosWidget'); ?>
                    <?php $this->endCache(); } ?>

                    <?php if ($this->beginCache('activity-page-4', array('duration' => 60))) { ?>
                        <?php $this->widget('DuelWidget'); ?>
                        <?php $this->widget('HumorWidget'); ?>
                    <?php $this->endCache(); } ?>


                </div>

                <div class="col-3">

                    <?php if ($this->beginCache('activity-page-5', array('duration' => 600))) { ?>
                        <?php $this->widget('TopFiveWidget'); ?>
                        <?php $this->widget('BlogPopularWidget'); ?>
                        <?php $this->widget('CommunityPopularWidget'); ?>
                    <?php $this->endCache(); } ?>

                </div>

            </div>

        </div>

    </div>

</div>