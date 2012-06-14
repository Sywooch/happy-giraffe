<?
    /**
     * @var CookRecipe $recipe
     */
?>

<div id="crumbs"><a href="">Главная</a> > <a href="">Сервисы</a> > <span>Приправы и специи</span></div>

<div id="cook-recipe">

    <div class="clearfix">

        <div class="add-recipe">

            Поделиться вкусненьким!<br/>
            <a href="<?=$this->createUrl('/cook/recipe/add')?>" class="btn btn-green"><span><span>Добавить рецепт</span></span></a>

        </div>

        <div class="search">

            <div class="title">
                <i class="icon"></i>
                <span>Поиск рецептов</span>
                <a href="">По ингредиентам</a>
                <a href="">По калорийности</a>
                <a href="">Расширеный поиск</a>
            </div>

            <form>
                <input type="text" placeholder="Введите ключевое слово в названии рецепта" />
                <button class="btn btn-purple-medium"><span><span>Найти</span></span></button>
            </form>

        </div>

    </div>

    <div class="clearfix">

        <div class="main">

            <div class="main-in">

                <div class="hrecipe">

                    <h1 class="fn"><?=$recipe->title?></h1>

                    <div class="date"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $recipe->created)?></div>

                    <div class="user clearfix">
                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $recipe->author, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
                    </div>

                    <div class="recipe-right">

                        <div class="recipe-description">

                            <ul>
                                <?php if ($recipe->cuisine): ?>
                                    <li>Кухня <span class="nationality"><!--<div class="flag flag-ua"></div> --><span class="cuisine-type"><?=$recipe->cuisine->title?></span></span></li>
                                <?php endif; ?>
                                <li>Время подготовки <span class="time-1"><i class="icon"></i><span class=""><?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?></span></span></li>
                                <li>Время приготовления <span class="time-2"><i class="icon"></i><span class=""><?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?></span></span></li>
                                <li>Кол-во порций <span class="yield-count"><i class="icon"></i><span class="yield"><?=$recipe->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></span></span></li>
                            </ul>

                            <div class="actions">

                                <div class="action">
                                    <a href="" class="print"><i class="icon"></i>Распечатать</a>
                                </div>

                                <div class="action">
                                    <a href="" class="add-to-cookbook"><i class="icon"></i>Добавить в кулинарную книгу</a>
                                </div>

                                <div class="action share">
                                    <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                                    Поделиться
                                    <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"></div>
                                </div>


                            </div>

                        </div>

                        <div class="nutrition">

                            <div class="block-title">Калорийность блюда</div>

                            <div class="portion">
                                <a href="" class="active">На 100 г.</a>
                                |
                                <a href="">На порцию</a>
                            </div>

                            <ul>
                                <li class="n-calories">
                                    <div class="icon">
                                        <i>К</i>
                                        Калории
                                    </div>
                                    <span class="calories">240</span> <span class="gray">ккал.</span>
                                </li>
                                <li class="n-protein">
                                    <div class="icon">
                                        <i>Б</i>
                                        Белки
                                    </div>
                                    <span class="protein">18</span> <span class="gray">г.</span>
                                </li>
                                <li class="n-fat">
                                    <div class="icon">
                                        <i>Ж</i>
                                        Жиры
                                    </div>
                                    <span class="fat">10</span> <span class="gray">г.</span>
                                </li>
                                <li class="n-carbohydrates">
                                    <div class="icon">
                                        <i>У</i>
                                        Углеводы
                                    </div>
                                    <span class="carbohydrates">70</span> <span class="gray">г.</span>
                                </li>

                            </ul>

                        </div>

                        <div class="nutrition diabetes">

                            <div class="block-title">Подходит для диабетики</div>

                            <ul>
                                <li class="n-bread">
                                    <div class="icon">
                                        <i>ХЕ</i>
                                        Хлебных единиц
                                    </div>
                                    <span class="calories">18,8</span> <span class="gray">х.е.</span>
                                </li>
                            </ul>


                        </div>

                    </div>

                    <div class="recipe-photo">

                        <?php if ($recipe->mainPhoto === null): ?>
                            <?php
                                $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                    'model' => $recipe,
                                    'many' => true,
                                    'customButton' => true,
                                    'customButtonHtmlOptions' => array('class' => 'fancy add-photo'),
                                ));
                            ?>
                                    <i class="icon"></i>
                                    <span>Вы уже готовили это блюдо?<br/>Добавьте фото!</span>
                            <?php
                                $this->endWidget();
                            ?>
                        <?php else: ?>
                            <div class="big">
                                <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(441, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'photo'))?>
                            </div>
                        <?php endif; ?>

                        <div class="thumbs clearfix">

                            <ul>
                                <?php foreach ($recipe->thumbs as $t): ?>
                                    <li><a href=""><?=CHtml::image($t->getPreviewUrl(78, 52, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP), $t->title)?></a></li>
                                <?php endforeach; ?>
                                <?php if ($recipe->mainPhoto !== null): ?>
                                    <li>
                                        <?php
                                            $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                                'model' => $recipe,
                                                'many' => true,
                                                'customButton' => true,
                                                'customButtonHtmlOptions' => array('class' => 'fancy add'),
                                            ));
                                        ?>
                                            <i class="icon"></i>
                                        <?php
                                            $this->endWidget();
                                        ?>
                                    </li>
                                <?php endif; ?>
                            </ul>

                        </div>

                    </div>

                    <div style="clear:left;"></div>

                    <h2>Ингредиенты</h2>

                    <ul class="ingredients">
                        <?php foreach ($recipe->ingredients as $i): ?>
                            <li class="ingredient">
                                <span class="name"><?=$i->ingredient->title?></span>
                                <span class="value"><?=round($i->value, 2)?></span>
                                <span class="type"><?=HDate::GenerateNoun(array($i->unit->title, $i->unit->title2, $i->unit->title3), $i->value)?></span>
                                <a href="" class="calculator-trigger tooltip" title="Открыть калькулятор мер"></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <h2>Приготовление</h2>

                    <div class="instructions wysiwyg-content">

                        <?=$recipe->text?>

                    </div>

                </div>

                <?php if ($recipe->more): ?>
                    <div class="cook-more clearfix">
                        <div class="block-title">
                            Еще вкусненькое
                        </div>
                        <ul>
                            <?php foreach($recipe->more as $m): ?>
                                <li>
                                    <div class="user clearfix">
                                        <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array('user' => $m->author, 'size' => 'small', 'location' => false, 'sendButton' => false)); ?>
                                    </div>
                                    <div class="item-title"><?=CHtml::link($m->title, $m->url)?></div>
                                    <div class="date"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $m->created)?></div>
                                    <div class="content">
                                        <?=$m->getPreview(243)?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php $this->widget('application.widgets.commentWidget.CommentWidget', array(
                    'model' => $recipe,
                )); ?>

            </div>

        </div>

        <div class="side-left">

            <div class="recipe-categories">

                <ul>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-0"></i>
                            <span>Все рецепты</span>

                        </a>
                        <span class="count">12 582</span>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-1"></i>
                            <span>Первые блюда</span>
                        </a>
                        <span class="count">582</span>
                    </li>
                    <li class="active">
                        <a href="" class="cook-cat active">
                            <i class="icon-cook-cat icon-recipe-2"></i>
                            <span>Вторые блюда</span>
                        </a>
                        <span class="count">1 125</span>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-3"></i>
                            <span>Салаты</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-4"></i>
                            <span>Закуски<br/>и&nbsp;бутерброды</span>

                        </a>
                        <span class="count">125 1525 152</span>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-5"></i>
                            <span>Сладкая выпечка</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-6"></i>
                            <span>Несладкая выпечка</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-7"></i>
                            <span>Торты<br/>и&nbsp;пирожные</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-8"></i>
                            <span>Десерты</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-9"></i>
                            <span>Напитки</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-10"></i>
                            <span>Соусы и&nbsp;кремы</span>
                        </a>
                    </li>
                    <li>
                        <a href="" class="cook-cat">
                            <i class="icon-cook-cat icon-recipe-11"></i>
                            <span>Консервация</span>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

    </div>

</div>