<?php
    Yii::app()->clientScript->registerMetaTag('NWGWm2TqrA1HkWzR8YBwRT08wX-3SRzeQIBLi1PMK9M', 'google-site-verification');
    Yii::app()->clientScript->registerMetaTag('41ad6fe875ade857', 'yandex-verification');
?>

<div id="homepage">

    <div class="content-cols clearfix">

        <div class="col-1">

            <?php $this->widget('CommunitiesWidget'); ?>

            <?php if (false): ?>
            <?php $contest_id = 9; ?>
                <div class="box">
                    <a href="<?=$this->createUrl('/contest/default/view', array('id' => $contest_id)) ?>"><img
                        src="/images/contest/banner-w240-<?=$contest_id?>-<?=mt_rand(1, 3)?>.jpg"></a>
                </div>
            <?php endif; ?>

        </div>

        <div class="col-23">

            <?php $this->widget('HelloWidget', array('user' => $user)); ?>

            <div class="clearfix">

                <div class="col-2">

                    <?php //if($this->beginCache('home-page-1', array('duration'=>60))) { ?>

                    <?php $this->widget('MostPopularWidget'); ?>
                    <?php $this->widget('OurServicesWidget'); ?>
                    <?php $this->widget('BlogWidget'); ?>

                    <?php //$this->endCache(); } ?>
                </div>

                <div class="col-3">

                    <?php //if($this->beginCache('home-page-2', array('duration'=>300))){ ?>
                    <?php $this->widget('OurUsersWidget'); ?>
                    <?php //$this->endCache(); } ?>

                    <div class="box homepage-articles">

                        <div class="title">Интерьер <span>и дизайн</span> <i>- сделаем все красиво!</i></div>

                        <ul>
                            <li><a href="/community/26/forum/"><img src="/images/homepage_articles_img.jpg"></a></li>
                            <li><a href="/community/26/forum/video/21203/">Интерьер детской комнаты</a></li>
                            <li><a href="/community/26/forum/post/21351/">Детская комната для маленьких гонщиков</a></li>
                        </ul>

                        <div class="all-link"><a href="/community/26/forum/">Все статьи (<?=CommunityContent::model()->cache(3600)->with('rubric')->count('community_id=26') ?>)</a></div>
                    </div>


                    <div class="box homepage-articles homepage-recipes">

                        <div class="title">Кулинарные <span>рецепты</span> <i>- <b>10000</b> рецептов</i></div>

                        <ul>
                            <li><a href="/cook/"><img src="/images/homepage_recipes_img.jpg"></a></li>
                            <li><a href="/community/22/forum/post/18804/">Как варить фасоль – быстро или качественно?</a></li>
                            <li><a href="/community/22/forum/post/21359/">Как сделать роллы в домашних условиях</a></li>
                        </ul>

                        <div class="all-link"><a href="/cook/">Все рецепты (<?=CookRecipe::model()->cache(3600)->count() ?>)</a></div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

