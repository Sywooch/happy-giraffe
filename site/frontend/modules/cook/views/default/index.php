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
                    <a href="">все рецепты (<?=$recipesCount?>)</a>
                </div>

                <div class="add-btn">
                    <a href="<?=$this->createUrl('/cook/recipe/add')?>" class="btn btn-green-medium"><span><span>Добавить рецепт</span></span></a>
                </div>


            </div>

            <ul class="list">

                <?php foreach ($recipes as $recipe): ?>
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
                        <?=CHtml::link($recipe->title, $recipe->url)?>
                    </div>
                    <div class="content">
                        <?=$recipe->getPreview(175)?>
                    </div>
                </li>
                <?php endforeach; ?>
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
            <?php foreach ($community->getLast(7) as $post): ?>
                <li>
                    <div class="user clearfix">
                        <?php
                            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                'user' => $post->author,
                                'size' => 'small',
                                'location' => false,
                                'sendButton' => false
                            ));
                        ?>
                    </div>
                    <div class="item-title"><?=CHtml::link($post->title, $post->url)?></div>
                    <div class="meta">
                        <span class="views">Просмотров:&nbsp;&nbsp;<?=PageView::model()->viewsByPath($post->url, true)?></span><br/>
                        <span class="comments"><?=CHtml::link('Комментариев:&nbsp;&nbsp;' . $post->commentsCount, $post->getUrl(true, false))?></span>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="all-link"><?=CHtml::link('Все записи клуба (' . $community->count . ')', $community->url)?></div>

    </div>

    <div class="banner-box">
        <a href="<?=$this->createUrl('/cook/spices')?>"><img src="/images/banner_05.png"/></a>
    </div>

    <div class="fast-services">

        <div class="block-title">Как выбирать <span>продукты в магазине или на рынке?</div>

        <ul>
            <li>
                <a href="<?=$this->createUrl('/cook/choose/category', array('id' => 'Myaso_ptica'))?>">
                    <img src="/images/fast_services_img_01.jpg"/>
                    <span>Как выбрать мясо?</span>
                </a>
            </li>
            <li>
                <a href="<?=$this->createUrl('/cook/choose', array('id' => 'Med'))?>">
                    <img src="/images/fast_services_img_02.jpg"/>
                    <span>Как выбрать мед?</span>
                </a>
            </li>
            <li>
                <a href="<?=$this->createUrl('/cook/choose', array('id' => 'Sir'))?>">
                    <img src="/images/fast_services_img_03.jpg"/>
                    <span>Как выбрать сыр?</span>
                </a>
            </li>

        </ul>

        <div class="all-link">
            <a href="<?=$this->createUrl('/cook/choose')?>" class="btn btn-green-small"><span><span>Весь прилавок</span></span></a>
        </div>

    </div>

</div>


</div>