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

            <?php if($this->beginCache('activity-page-live', array(
                'duration' => 600,
                'dependency' => array(
                    'class' => 'CDbCacheDependency',
                    'sql' => 'SELECT MAX(created) FROM community__contents',
                ),
            ))): ?>
                <?php $this->widget('LiveWidget'); ?>
            <?php $this->endCache(); endif;  ?>

            <?php $this->widget('WantToChatWidget'); ?>

            <?=$this->renderPartial('//_banner')?>

        </div>

        <div class="col-23">

            <div class="clearfix">

                <div class="col-2">

                    <?php if($this->beginCache('activity-page-video', array(
                        'duration' => 600,
                        'varyByExpression' => 'Favourites::getIdListForView(Favourites::BLOCK_VIDEO, 1)',
                    ))): ?>
                        <?php $this->widget('VideoWidget'); ?>
                    <?php $this->endCache(); endif;  ?>

                    <?php if($this->beginCache('activity-page-friends', array(
                        'duration' => 600,
                        'varyByExpression' => 'Yii::app()->user->id',
                    ))): ?>
                        <?php $this->widget('FriendsWidget'); ?>
                    <?php $this->endCache(); endif;  ?>

                    <?php if($this->beginCache('activity-page-random-photos', array(
                        'duration' => 600,
                    ))): ?>
                        <?php $this->widget('RandomPhotosWidget'); ?>
                    <?php $this->endCache(); endif;  ?>

                    <?php $this->widget('DuelWidget'); ?>

                </div>

                <div class="col-3">

                <?php if($this->beginCache('activity-page-top-five', array(
                    'duration' => 600,
                ))): ?>
                    <?php $this->widget('TopFiveWidget'); ?>
                <?php $this->endCache(); endif;  ?>

                <?php if($this->beginCache('activity-page-blog-popular', array(
                    'duration' => 600,
                ))): ?>
                    <?php $this->widget('BlogPopularWidget'); ?>
                <?php $this->endCache(); endif; ?>

                <?php if($this->beginCache('activity-page-community-popular', array(
                    'duration' => 600,
                ))): ?>
                    <?php $this->widget('CommunityPopularWidget'); ?>
                <?php $this->endCache(); endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>