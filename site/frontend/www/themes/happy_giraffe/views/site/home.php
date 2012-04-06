<div id="homepage">

<div class="content-cols clearfix">

<div class="col-1">

    <?php $this->widget('CommunitiesWidget'); ?>

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

    <div class="box homepage-blogs">

        <div class="title"><span>Блоги</span> мам и пап</div>

        <ul>
            <li>
                <div class="clearfix">
                    <div class="user-info">
                        <a href="" class="ava small female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Александр</a>
                        </div>
                    </div>
                </div>
                <b><a href="">В гостях у Айболита</a></b>
                <div class="img"><a href=""><img src="/images/homepage_blogs_img_01.jpg"></a></div>
            </li>
            <li>
                <div class="clearfix">
                    <div class="user-info">
                        <a href="" class="ava small female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Александр</a>
                        </div>
                    </div>
                </div>
                <b><a href="">Наш малыш будет похож на папу</a></b>
                <div class="img"><a href=""><img src="/images/homepage_blogs_img_02.jpg"></a></div>
            </li>
            <li>
                <div class="clearfix">
                    <div class="user-info">
                        <a href="" class="ava small female"></a>
                        <div class="details">
                            <span class="icon-status status-offline"></span>
                            <a href="" class="username">Александр</a>
                        </div>
                    </div>
                </div>
                <b><a href="">Фруктовые пюре - ЗА и ПРОТИВ!</a></b>
                <div class="img"><a href=""><img src="/images/homepage_blogs_img_03.jpg"></a></div>
            </li>
            <li>
                <div class="clearfix">
                    <div class="user-info">
                        <a href="" class="ava small female"></a>
                        <div class="details">
                            <span class="icon-status status-offline"></span>
                            <a href="" class="username">Александр</a>
                        </div>
                    </div>
                </div>
                <b><a href="">Почему завтракать – так полезно?</a></b>
                <div class="img"><a href=""><img src="/images/homepage_blogs_img_04.jpg"></a></div>
            </li>
            <li>
                <div class="clearfix">
                    <div class="user-info">
                        <a href="" class="ava small female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Александр</a>
                        </div>
                    </div>
                </div>
                <b><a href="">Социальная помощь – служба помощи семье</a></b>
                <div class="img"><a href=""><img src="/images/homepage_blogs_img_05.jpg"></a></div>
            </li>
            <li>
                <div class="clearfix">
                    <div class="user-info">
                        <a href="" class="ava small female"></a>
                        <div class="details">
                            <span class="icon-status status-offline"></span>
                            <a href="" class="username">Александр</a>
                        </div>
                    </div>
                </div>
                <b><a href="">Кризисы семейной жизни</a></b>
                <div class="img"><a href=""><img src="/images/homepage_blogs_img_06.jpg"></a></div>
            </li>

        </ul>

    </div>

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