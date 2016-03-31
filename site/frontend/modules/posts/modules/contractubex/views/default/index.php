<?php
$this->pageTitle = 'Контрактубекс';
$this->hideAdsense = true;
?>

<div class="header-banner clearfix">
    <div class="header-banner_static">
        <h1 class="header-banner_static_heading" style="font-size: 40px;">Как правильно лечить шрамы?</h1>
        <div class="header-banner_static_img"></div>
    </div>
    <div class="header-banner_dynamic">
        <ul class="header-banner_dynamic_slider">
            <li class="header-banner_dynamic_slider_item"><img src="/../lite/images/contratubex/promo-slider-item1.png"></li>
            <li class="header-banner_dynamic_slider_item hidden"><img src="/../lite/images/contratubex/promo-slider-item2.png"></li>
        </ul>
    </div>
</div>

<div class="b-main_cont">
    <?php $this->widget('site\frontend\modules\posts\modules\contractubex\widgets\mainPosts\MainPostsWidget', array('limit' => 3)); ?>
    <?php $this->renderPartial('_promo'); ?>
    <div class="club-share-advice clearfix">
        <h1 class="club-share-advice_heading">
            А как Вы боретесь<br>
            со шрамами?
        </h1>
        <a class="club-share-advice_button <?=(Yii::app()->user->isGuest) ? 'login-button' : 'fancy-top'?>" data-bind="follow: {}" href="<?=$this->createUrl('/blog/default/form', array('type' => 1, 'club_id' => $forum->id, 'useAMD' => true))?>">Поделись советом!</a>
    </div>

    <?php $this->widget('site\frontend\modules\posts\modules\contractubex\widgets\activityWidget\ActivityWidget'); ?>

    <?php $this->renderPartial('/_promo_info'); ?>
</div>
