<?php
    Yii::app()->clientScript->registerMetaTag('NWGWm2TqrA1HkWzR8YBwRT08wX-3SRzeQIBLi1PMK9M', 'google-site-verification');
    Yii::app()->clientScript->registerMetaTag('41ad6fe875ade857', 'yandex-verification');
?>

<div id="homepage">

    <div class="content-cols clearfix">

        <div class="col-1">

            <?php $this->widget('CommunitiesWidget'); ?>

            <?php $contest_id = 5; ?>
            <div class="box">
                <a href="<?=$this->createUrl('/contest/default/view', array('id' => $contest_id)) ?>"><img
                    src="/images/contest/banner-w240-<?=$contest_id?>.jpg"></a>
            </div>

        </div>

        <div class="col-23">

            <?php $this->widget('HelloWidget', array('user' => $user)); ?>

            <div class="clearfix">

                <div class="col-2">

<?php if($this->beginCache('home-page-1', array('duration'=>60))) { ?>

                    <?php $this->widget('MostPopularWidget'); ?>
                    <?php $this->widget('OurServicesWidget'); ?>

<?php $this->endCache(); } ?>
                    <?php $this->widget('BlogWidget'); ?>

                </div>

                <div class="col-3">

                    <?php $this->widget('OurUsersWidget'); ?>

<?php if($this->beginCache('home-page-2', array('duration'=>600))) { ?>

                    <div class="box homepage-articles">

                        <div class="title">Интерьер <span>и дизайн</span> <i>- сделаем все красиво!</i></div>

                        <?php $this->widget('CommunityArticlesWidget', array(
                            'community_id' => 26,
                            'title' => 'статьи',
                            'image' => 'homepage_articles_img.jpg',
                        )); ?>

                    </div>

                    <div class="box homepage-articles homepage-recipes">

                        <div class="title">Кулинарные <span>рецепты</span> <i>- <b>10000</b> рецептов</i></div>

                        <?php $this->widget('CommunityArticlesWidget', array(
                            'community_id' => 22,
                            'title' => 'рецепты',
                            'image' => 'homepage_recipes_img.jpg',
                        )); ?>

                    </div>
<?php $this->endCache(); } ?>

                </div>

            </div>

        </div>

    </div>

</div>

