<div id="homepage">

<div class="content-cols clearfix">

<div class="col-1">

    <?php //$this->widget('CommunitiesWidget'); ?>

    <div class="box">
        <a href="<?=$this->createUrl('/contest/view', array('id' => 1)) ?>"><img src="/images/banner_03.png"></a>
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

    <?php $this->widget('CommunityArticlesWidget',array('community_id'=>26)); ?>

    <div class="box homepage-articles homepage-recipes">

        <div class="title">Кулинарные рецепты <span>- <b>1000</b> рецептов</span></div>

        <ul>
            <li><a href=""><img src="/images/homepage_recipes_img.jpg"></a></li>
            <li><a href="">Как приготовить в домашних условиях суши</a></li>
            <li><a href="">У меня очень придирчивые мои любимые дети. Все им не вкусно!</a></li>
        </ul>

        <div class="all-link"><a href="">Все рецепты (2589)</a></div>

    </div>

</div>

</div>

</div>

</div>

</div>