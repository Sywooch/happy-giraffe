<div id="cook" class="clearfix">

<div class="title">
    <h2>Кулинария <span>Готовьте с Веселым Жирафом!</span></h2>
</div>

<div class="main">
    <div class="main-right">


        <div class="search clearfix">

            <div class="title">

                <div class="links">
                    <a href="">По ингредиентам</a>
                    <a href="">Расширеный поиск</a>
                </div>

                <i class="icon"></i>
                <span>Поиск рецептов</span>

            </div>

            <form>
                <input type="text" placeholder="Введите ключевое слово в названии рецепта"/>
                <button class="btn btn-purple-medium"><span><span>Найти</span></span></button>
            </form>

        </div>

        <div class="recipe-list">

            <div class="block-title">

                <div class="title-in">
                    <span class="yellow">Тысячи рецептов</span><br/>
                    <span>от наших пользователей</span>
                </div>

                <div class="all-link">
                    <span>Смотреть</span><br/>
                    <a href="">все рецепты (5268)</a>
                </div>

                <div class="add-btn">
                    <a href="<?=$this->createUrl('/cook/recipe/form')?>" class="btn btn-green-medium"><span><span>Добавить рецепт</span></span></a>
                </div>


            </div>

            <ul class="list">

                <?php foreach ($recipes as $recipe) { ?>
                <li>
                    <div class="user clearfix">
                        <?php
                        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $recipe->author,
                            'size' => 'small',
                            'location' => false,
                            'sendButton' => false
                        ));
                        ?>
                    </div>
                    <div class="item-title">
                        <a href="<?=$recipe->url?>"><?=$recipe->title?></a>
                    </div>
                    <div class="content">
                        <a href=""><?=$recipe->getPreview(175)?></a>
                    </div>
                </li>
                <?php } ?>
            </ul>

        </div>

        <div class="cook-teasers clearfix">

            <div class="block-title">Полезные сервисы для кулинара</div>

            <ul>
                <li>
                    <div class="img">
                        <a href="<?=$this->createUrl('/cook/converter')?>"><img src="/images/cook_teaser_img_01.png"/></a>
                    </div>
                    <div class="text">
                        <div class="item-title"><a href="<?=$this->createUrl('/cook/converter')?>">Калькулятор мер</a></div>
                        <p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
                    </div>
                </li>
                <li>
                    <div class="img">
                        <a href="<?=$this->createUrl('/cook/calorisator')?>"><img src="/images/cook_teaser_img_02.png"/></a>
                    </div>
                    <div class="text">
                        <div class="item-title"><a href="<?=$this->createUrl('/cook/calorisator')?>">Счетчик калорий</a></div>
                        <p>Узнавайте сколько калорий, а также белков, жиров и углеводов в любых продуктах.</p>
                    </div>
                </li>

            </ul>

        </div>


        <div class="dish-list">

            <div class="block-title clearfix">
                <a href="<?=$this->createUrl('/cook/decor')?>" class="btn btn-green-medium"><span><span>Смотреть коллекцию<i class="arr-r"></i></span></span></a>
                Как оформить свое блюдо!
            </div>

            <ul class="list">
                <?php foreach ($decorations as $decoration) { ?>
                <li><?=$decoration->preview?></li>
                <?php } ?>
            </ul>

        </div>


    </div>
</div>

<div class="side-right">

    <div class="fast-articles">

        <div class="block-title">
            Общайся в клубе <span>на кулинарные темы</span>
        </div>

        <ul>
            <li>
                <div class="user clearfix">
                    <div class="user-info clearfix">
                        <a class="ava female small"></a>

                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Дарья</a>
                        </div>
                    </div>
                </div>
                <div class="item-title"><a href="">Проблемы с неврологией и психиатрией в раннем возрасте</a></div>
                <div class="meta">
                    <span class="views">Просмотров:&nbsp;&nbsp;465</span><br/>
                    <span class="comments"><a href="">Комментариев:&nbsp;&nbsp;18</a></span>
                </div>
            </li>
            <li>
                <div class="user clearfix">
                    <div class="user-info clearfix">
                        <a class="ava female small"></a>

                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Дарья</a>
                        </div>
                    </div>
                </div>
                <div class="item-title"><a href="">Проблемы с неврологией и психиатрией</a></div>
                <div class="meta">
                    <span class="views">Просмотров:&nbsp;&nbsp;465</span><br/>
                    <span class="comments"><a href="">Комментариев:&nbsp;&nbsp;18</a></span>
                </div>
            </li>
            <li>
                <div class="user clearfix">
                    <div class="user-info clearfix">
                        <a class="ava female small"></a>

                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Дарья</a>
                        </div>
                    </div>
                </div>
                <div class="item-title"><a href="">Проблемы с неврологией и психиатрией в раннем возрасте</a></div>
                <div class="meta">
                    <span class="views">Просмотров:&nbsp;&nbsp;465</span><br/>
                    <span class="comments"><a href="">Комментариев:&nbsp;&nbsp;18</a></span>
                </div>
            </li>

        </ul>

        <div class="all-link"><a href="">Все записи клуба (8 258)</a></div>

    </div>

    <div class="banner-box">
        <a href="<?=$this->createUrl('/cook/spices')?>"><img src="/images/banner_05.png"/></a>
    </div>

    <div class="fast-services">

        <div class="block-title">Как выбирать <span>продукты в магазине или на рынке?</div>

        <ul>
            <li>
                <a href="<?=$this->createUrl('/cook/choose/category', array('id'=>'Myaso_ptica'))?>">
                    <img src="/images/fast_services_img_01.jpg"/>
                    <span>Как выбрать мясо?</span>
                </a>
            </li>
            <li>
                <a href="<?=$this->createUrl('/cook/choose', array('id'=>'Med'))?>">
                    <img src="/images/fast_services_img_02.jpg"/>
                    <span>Как выбрать мед?</span>
                </a>
            </li>
            <li>
                <a href="<?=$this->createUrl('/cook/choose', array('id'=>'Sir'))?>">
                    <img src="/images/fast_services_img_03.jpg"/>
                    <span>Как выбрать сыр?</span>
                </a>
            </li>

        </ul>

        <div class="all-link">
            <a href="" class="btn btn-green-small"><span><span>Весь прилавок</span></span></a>
        </div>

    </div>

</div>


</div>