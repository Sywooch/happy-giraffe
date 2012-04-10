<div id="homepage">

    <div class="content-cols clearfix">

        <div class="col-1">

            <?php $this->widget('CommunitiesWidget'); ?>

            <div class="box">
                <a href="<?=$this->createUrl('/contest/view', array('id' => 1)) ?>"><img
                    src="/images/banner_03.png"></a>
            </div>

        </div>

        <div class="col-23">

            <?php $this->widget('HelloWidget', array('user' => $user)); ?>

            <div class="clearfix">

                <div class="col-2">

                    <?php $this->widget('MostPopularWidget'); ?>

                    <?php $this->widget('OurServicesWidget'); ?>

                    <?php $this->widget('BlogWidget'); ?>

                </div>

                <div class="col-3">

                    <?php $this->widget('OurUsersWidget'); ?>

                    <div class="box homepage-articles">

                        <div class="title">Интерьер и дизайн <span>- сделаем все красиво!</span></div>

                        <?php $this->widget('CommunityArticlesWidget', array(
                            'community_id' => 26,
                            'title' => 'статьи',
                            'image' => 'homepage_articles_img.jpg',
                        )); ?>

                    </div>

                    <div class="box homepage-articles homepage-recipes">

                        <div class="title">Кулинарные рецепты <span>- <b>3000</b> рецептов</span></div>

                        <?php $this->widget('CommunityArticlesWidget', array(
                            'community_id' => 22,
                            'title' => 'рецепты',
                            'image' => 'homepage_recipes_img.jpg',
                        )); ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>