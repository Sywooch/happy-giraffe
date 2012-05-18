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

            <div class="banner">
                <a href=""><img src="/images/banner_04.png"></a>
            </div>

        </div>

        <div class="col-23">

            <div class="clearfix">

                <div class="col-2">

                    <?php $this->widget('VideoWidget'); ?>

                    <?php $this->widget('FriendsWidget'); ?>

                    <?php $this->widget('RandomPhotosWidget'); ?>

                    <?php $this->widget('DuelWidget'); ?>

                    <!--<div class="box activity-smile">

                        <div class="title">Улыбнись <span>вместе с нами</span> <img src="/images/activity_smile_smile.png" /></div>

                        <div class="img">
                            <img src="/images/activity_smile_img.jpg" />
                        </div>

                        <div class="options">

                            <div class="option">
                                <span class="text"><span>Ха-ха-ха!</span></span>
                                <span class="value">28</span>
                            </div>

                            <div class="option">
                                <span class="text"><span>Ха!</span></span>
                                <span class="value">16</span>
                            </div>

                            <div class="option">
                                <span class="text"><span>:(</span></span>
                                <span class="value">11</span>
                            </div>

                        </div>

                    </div>-->

                </div>

                <div class="col-3">

                    <?php $this->widget('TopFiveWidget'); ?>
                    <?php //$this->widget('PopularWidget'); ?>

                </div>

            </div>

        </div>

    </div>

</div>