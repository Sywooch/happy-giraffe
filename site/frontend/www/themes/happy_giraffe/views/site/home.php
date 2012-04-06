<div id="homepage">

<div class="content-cols clearfix">

<div class="col-1">

    <div class="box homepage-clubs">

        <div class="title"><span>Клубы</span> для общения</div>

        <ul>
            <li class="kids">
                <div class="category-title">Дети и беременность</div>
                <ul>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_1.png"></span>
                            <span class="club-title">Планирование</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_4.png"></span>
                            <span class="club-title">Дети до года</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_8.png"></span>
                            <span class="club-title">Дети старше года</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_12.png"></span>
                            <span class="club-title">Дошкольники</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_15.png"></span>
                            <span class="club-title">Школьники</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="manwoman">
                <div class="category-title">Мужчина <span>&amp;</span> женщина</div>
                <ul>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_19.png"></span>
                            <span class="club-title">Отношения</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_20.png"></span>
                            <span class="club-title">Свадьба</span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="beauty">
                <div class="category-title">Красота и здоровье</div>
                <ul>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_21.png"></span>
                            <span class="club-title">Красота</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_22.png"></span>
                            <span class="club-title">Мода и шопинг</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_23.png"></span>
                            <span class="club-title">Здоровье родителей</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="home">
                <div class="category-title">Дом</div>
                <ul>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_24.png"></span>
                            <span class="club-title">Кулинарные рецепты</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_25.png"></span>
                            <span class="club-title">Детские рецепты</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_26.png"></span>
                            <span class="club-title">Интерьер и дизайн</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_27.png"></span>
                            <span class="club-title">Домашние хлопоты</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_28.png"></span>
                            <span class="club-title">Загородная жизнь</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="hobbies">
                <div class="category-title">Интересы и увлечения</div>
                <ul>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_29.png"></span>
                            <span class="club-title">Своими руками</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_30.png"></span>
                            <span class="club-title">Мастерим детям</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_31.png"></span>
                            <span class="club-title">За рулем</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_32.png"></span>
                            <span class="club-title">Цветоводство</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="rest">
                <div class="category-title">Отдых</div>
                <ul>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_29.png"></span>
                            <span class="club-title">Выходные с ребенком</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_30.png"></span>
                            <span class="club-title">Путешествия семьей</span>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <span class="club-img"><img src="/images/club_img_31.png"></span>
                            <span class="club-title">Праздники</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>

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

    <div class="box homepage-articles">

        <div class="title">Интерьер и дизайн <span>- сделаем все красиво!</span></div>

        <ul>
            <li><a href=""><img src="/images/homepage_articles_img.jpg"></a></li>
            <li><a href="">Сделаем хай-тек у себя на кухне собственными силами</a></li>
            <a href=""></a><li><a href="">Состав и свойства наливного пола. Заливаем пол сами</a></li>
        </ul>

        <div class="all-link"><a href="">Все статьи (2589)</a></div>

    </div>

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