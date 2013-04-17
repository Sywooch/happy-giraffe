<?php
/* @var $this Controller
 * @var CookDecoration[] $decorations
 */
?>
<div id="cook" class="clearfix">

    <div class="title">
        <h2>Кулинария <span>Готовьте с Веселым Жирафом!</span></h2>
    </div>

    <div class="main">
        <div class="main-right">


            <div class="search clearfix">

                <div class="title">

                    <div class="links">
                        <?=HHtml::link('По ингредиентам', array('/cook/recipe/searchByIngredients'), array(), true)?>
                        <?=HHtml::link('Расширеный поиск', array('/cook/recipe/advancedSearch'), array(), true)?>
                    </div>

                    <i class="icon"></i>
                    <span>Поиск рецептов</span>

                </div>

                <?=CHtml::beginForm('/cook/recipe/search', 'get')?>
                <input name="text" type="text" placeholder="Введите ключевое слово в названии рецепта"/>
                <button class="btn btn-purple-medium"><span><span>Найти</span></span></button>
                <?=CHtml::endForm()?>

            </div>

            <div class="recipe-list">

                <div class="block-title">

                    <div class="title-in">
                        <span class="yellow">Тысячи рецептов</span><br/>
                        <span>от наших пользователей</span>
                    </div>

                    <div class="all-link">
                        <span>Смотреть</span><br/>
                        <?=CHtml::link('все рецепты (' . $recipesCount . ')', '/cook/recipe/')?>
                    </div>

                    <div class="add-btn">
                        <a href="<?=(Yii::app()->user->isGuest) ? '#login' : $this->createUrl('/cook/recipe/add')?>"
                           class="btn btn-green-medium<?php if (Yii::app()->user->isGuest): ?> fancy<?php endif; ?>" data-theme="white-square"><span><span>Добавить рецепт</span></span></a>
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
                                'sendButton' => false,
                                'hideLinks'=>true
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
                            <?=HHtml::link('<img src="/images/cook_teaser_img_01.png"/>', $this->createUrl('/cook/converter'), array(), true) ?>
                        </div>
                        <div class="text">
                            <div class="item-title"><a href="<?=$this->createUrl('/cook/converter')?>">Калькулятор мер</a></div>
                            <p>Сервис для перевода веса и объема продуктов в понятные для вас меры.</p>
                        </div>
                    </li>
                    <li>
                        <div class="img">
                            <?=HHtml::link('<img src="/images/cook_teaser_img_02.png"/>', $this->createUrl('/cook/calorisator'), array(), true) ?>
                        </div>
                        <div class="text">
                            <div class="item-title"><a href="<?=$this->createUrl('/cook/calorisator')?>">Счетчик калорий</a></div>
                            <p>Узнавайте сколько калорий, а также белков, жиров и углеводов в любых продуктах.</p>
                        </div>
                    </li>

                </ul>

            </div>

            <div class="recipe-banner recipe-banner-1">

                <div class="block-title">
                    <span>2500 рецептов<br/>для мультиварки</span>
                    <a href="<?=$this->createUrl('/cook/recipe/index', array('section' => 1))?>">Готовим в мультиварке <i class="arr">&rarr;</i></a>
                </div>

            </div>


            <div class="dish-list">

                <div class="block-title clearfix">
                    <a href="<?=$this->createUrl('/cook/decor')?>" class="btn btn-green-medium"><span><span>Смотреть коллекцию<i class="arr-r"></i></span></span></a>
                    Как оформить свое блюдо!
                </div>

                <ul class="list">
                    <?php foreach ($decorations as $decoration) { ?>
                    <li><a href="<?=$decoration->url ?>"><img src="<?=$decoration->photo->getPreviewUrl(176, 176, false, true)?>" alt="<?=$decoration->title ?>"></a></li>
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
                            'sendButton' => false,
                            'hideLinks'=>true
                        ));
                        ?>
                    </div>
                    <div class="item-title"><?=CHtml::link($post->title, $post->url)?></div>
                    <div class="meta">
                        <span class="views">Просмотров:&nbsp;&nbsp;<?=PageView::model()->viewsByPath($post->url, true)?></span><br/>
                        <span class="comments"><?=HHtml::link('Комментариев:&nbsp;&nbsp;' . $post->commentsCount, $post->getUrl(true, false), array(),true)?></span>
                    </div>
                </li>
                <?php endforeach; ?>
            </ul>

            <div class="all-link"><?=CHtml::link('Все записи клуба (' . $community->count . ')', $community->url)?></div>

        </div>

        <div class="banner-box">
            <?php $this->renderPartial('//_banner'); ?>
        </div>

        <div class="fast-services">

            <div class="block-title">Как выбирать <span>продукты в магазине или на рынке?</div>


            <ul>

                <?php foreach ($chooses as $choose): ?>
                <li>
                    <a href="<?=$this->createUrl('/cook/choose/view', array('id' => $choose->slug))?>">
                        <img src="<?=isset($choose->photo) ? $choose->photo->getPreviewUrl(69, 57, Image::WIDTH) : '' ?>"/>
                        <span>Как выбрать <?=$choose->title_accusative?>?</span>
                    </a>
                </li>
                <?php endforeach; ?>

            </ul>

            <div class="all-link">
                <a href="<?=$this->createUrl('/cook/choose')?>" class="btn btn-green-small"><span><span>Весь прилавок</span></span></a>
            </div>

        </div>

    </div>


</div>