<div class="b-article clearfix" id="recipe">
    <div class="float-l">
        <div class="like-control like-control__small-indent clearfix">
            <a href="" class="ava male">
                <span class="icon-status status-online"></span>
                <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
            </a>
        </div>
        <div class="js-like-control">
            <div class="like-control like-control__pinned clearfix">
                <a href="" class="like-control_ico like-control_ico__like">865</a>
                <a href="" class="like-control_ico like-control_ico__repost">5</a>
                <a href="" class="like-control_ico like-control_ico__cook ">123865</a>
            </div>
        </div>
    </div>
    <!-- hrecipe -->
    <div class="b-article_cont hrecipe clearfix">
        <div class="b-article_cont-tale"></div>
        <div class="b-article_header clearfix">
            <div class="meta-gray">
                <a href="<?= $recipe->getUrl(true) ?>" class="meta-gray_comment">
                    <span class="ico-comment ico-comment__gray"></span>
                    <span class="meta-gray_tx"><?=$recipe->commentsCount ?></span>
                </a>
                <div class="meta-gray_view">
                    <span class="ico-view ico-view__gray"></span>
                    <span class="meta-gray_tx"><?=PageView::model()->viewsByPath($recipe->getUrl())?></span>
                </div>
            </div>
            <div class="float-l">
                <a href="<?=$recipe->author->getUrl() ?>" class="b-article_author"><?=$recipe->author->getFullName() ?></a>
                <span class="font-smallest color-gray"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $recipe->created)?></span>
            </div>
        </div>
        <!-- Название блюда должно иметь класс fn  для микроформатов -->
        <h1 class="b-article_t fn">
            Торт «Зебра»
        </h1>
        <div class="b-article_in clearfix">
            <div class="wysiwyg-content clearfix">
                <!--<p>У меня есть уже один рецепт "Зебры".А этим рецептом поделилась со мной моя читательница...Я обещала попробовать сделать, и вот... я сделала! Эта "Зебра" у меня  получилась  воздушнее, мягче, рассыпчатей... По вкусу напомнила кекс... Остается мягкой и вкусной даже на следующий день! </p>-->
                <?php if ($recipe->mainPhoto !== null): ?>
                    <div class="b-article_in-img">
                        <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(580, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'content-img'))?>
                    </div>
                <?php else: ?>
                    <br>
                <?php endif; ?>

                <!-- Всталвять или после изображения или после <br> или пустого <p> -->
                <div class="recipe-desc clearfix">
                    <?php if ($recipe->cuisine): ?>
                        <div class="location clearfix">
                            <?php if (!empty($recipe->cuisine->country_id)):?>
                                <span class="flag-big flag-big-<?=$recipe->cuisine->country->iso_code ?>"></span>
                            <?php endif; ?>
                            <span class="location_tx"><?=$recipe->cuisine->title?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($recipe->preparation_duration || $recipe->cooking_duration): ?>
                        <div class="recipe-desc_holder">
                            <?php if ($recipe->preparation_duration): ?>
                                <div class="recipe-desc_i">
                                    <div class="recipe-desc_ico recipe-desc_ico__time-1 powertip" title="Время подготовки"></div>
                                    <?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?>
                                </div>
                            <?php endif; ?>
                            <?php if ($recipe->cooking_duration): ?>
                                <div class="recipe-desc_i">
                                    <div class="recipe-desc_ico recipe-desc_ico__time-2 powertip" title="Время приготовления"></div>
                                    <?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($recipe->servings): ?>
                        <div class="recipe-desc_i">
                            <div class="recipe-desc_ico recipe-desc_ico__yield powertip" title="Количество порций"></div>
                            на <span class="yeild"><?=$recipe->servings?> <?=Str::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></span>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="clearfix">
                    <div class="nutrition float-r">
                        <a class="nutrition_t a-pseudo" data-bind="click: rootNutritionHandler">Калорийность блюда - 588 ккал</a>

                        <div class="nutrition_hold" data-bind="css: { 'display-b' : showNutritions() !== false }">
                            <div class="nutrition_portion">
                                <a class="nutrition_portion-a" data-bind="css: { active : showNutritions() == SHOW_NUTRITIONS_100G }, click: function(data, event) { setNutrition(SHOW_NUTRITIONS_100G, data, event) }">На 100 г</a>
                                <?php if ($recipe->servings): ?>
                                    <a class="nutrition_portion-a" data-bind="css: { active : showNutritions() == SHOW_NUTRITIONS_SERVING }, click: function(data, event) { setNutrition(SHOW_NUTRITIONS_SERVING, data, event) }">На порцию</a>
                                <?php endif; ?>
                            </div>
                            <ul class="nutrition_ul" data-bind="visible: showNutritions() == SHOW_NUTRITIONS_100G">
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__calories">
                                        <i>К</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Калории -
                                        <span class="calories"><?=$recipe->getNutritionalsPer100g(1)?></span>
                                        <span class="nutrition_measure">ккал.</span>
                                    </div>
                                </li>
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__protein">
                                        <i>Б</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Белки -
                                        <span class="protein"><?=$recipe->getNutritionalsPer100g(3)?></span>
                                        <span class="nutrition_measure">г.</span>
                                    </div>
                                </li>
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__fat">
                                        <i>Ж</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Жиры -
                                        <span class="fat"><?=$recipe->getNutritionalsPer100g(2)?></span>
                                        <span class="nutrition_measure">г.</span>
                                    </div>
                                </li>
                                <li class="nutrition_li">
                                    <div class="nutrition_icon nutrition_icon__carbohydrates">
                                        <i>У</i>
                                    </div>
                                    <div class="nutrition_tx">
                                        Углеводы -
                                        <span class="carbohydrates"><?=$recipe->getNutritionalsPer100g(4)?></span>
                                        <span class="nutrition_measure">г.</span>
                                    </div>
                                </li>

                            </ul>
                            <?php if ($recipe->servings): ?>
                                <ul class="nutrition_ul" data-bind="visible: showNutritions() == SHOW_NUTRITIONS_SERVING">
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__calories">
                                            <i>К</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Калории -
                                            <span class="calories"><?=$recipe->getNutritionalsPerServing(1)?></span>
                                            <span class="nutrition_measure">ккал.</span>
                                        </div>
                                    </li>
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__protein">
                                            <i>Б</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Белки -
                                            <span class="protein"><?=$recipe->getNutritionalsPerServing(3)?></span>
                                            <span class="nutrition_measure">см.</span>
                                        </div>
                                    </li>
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__fat">
                                            <i>Ж</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Жиры -
                                            <span class="fat"><?=$recipe->getNutritionalsPerServing(2)?></span>
                                            <span class="nutrition_measure">г.</span>
                                        </div>
                                    </li>
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__carbohydrates">
                                            <i>У</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Углеводы -
                                            <span class="carbohydrates"><?=$recipe->getNutritionalsPerServing(4)?></span>
                                            <span class="nutrition_measure">г.</span>
                                        </div>
                                    </li>

                                </ul>
                            <?php endif; ?>
                        </div>


                    </div>

                    <?php if ($recipe->ingredients): ?>
                        <h2 class="wysiwyg-content_t-sub">Ингредиенты</h2>
                        <ul class="ingredients">
                            <?php foreach ($recipe->ingredients as $i): ?>
                                <li class="ingredient">
                                    <span class="name"><?=$i->ingredient->title?></span>
                                    - <span class="amount">
                                    <?php if ($i->unit->type != 'undefined'): ?><?=$i->display_value?>&nbsp;<?php endif; ?><?=$i->noun?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>


                <h2 class="wysiwyg-content_t-sub">Приготовление</h2>
                <?=$recipe->purified->text?>
            </div>
            <div class="clearfix">
                <?php if ($recipe->servings): ?>
                <div class="cook-diabets">
                    <div class="cook-diabets-chart <?=$recipe->getBakeryItemsCssClass() ?>">
                        <span class="text"><?=$recipe->bakeryItems?></span>
                    </div>
                    <div class="cook-diabets-desc"><?=$recipe->getBakeryItemsText() ?></div>
                </div>
                <?php endif; ?>

                <?php $tags = $recipe->getNotEmptyTags(); ?>
                <?php if ($tags): ?>
                <div class="cook-article-tags">
                    <div class="cook-article-tags-title">Теги</div>
                    <ul class="cook-article-tags-list">
                        <?php foreach ($tags as $tag): ?>
                            <li><a href="<?=$tag->getUrl() ?>"><?=strip_tags($tag->title) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="custom-likes-b">
            <div class="custom-likes-b_slogan">Поделитесь с друзьями!</div>
            <a href="" class="custom-like">
                <span class="custom-like_icon odnoklassniki"></span>
                <span class="custom-like_value">0</span>
            </a>
            <a href="" class="custom-like">
                <span class="custom-like_icon vkontakte"></span>
                <span class="custom-like_value">1900</span>
            </a>

            <a href="" class="custom-like">
                <span class="custom-like_icon facebook"></span>
                <span class="custom-like_value">150</span>
            </a>

            <a href="" class="custom-like">
                <span class="custom-like_icon twitter"></span>
                <span class="custom-like_value">10</span>
            </a>
        </div>
        <div class="nav-article clearfix">
            <div class="nav-article_left">
                <a href="" class="nav-article_arrow nav-article_arrow__left"></a>
                <a href="" class="nav-article_a">Очень красивые пропорции у нашего ведущего</a>
            </div>
            <div class="nav-article_right">
                <a href="" class="nav-article_arrow nav-article_arrow__right"></a>
                <a href="" class="nav-article_a">Очень красивые пропорции Очень красивые пропорции у нашего ведущего у нашего ведущего</a>
            </div>
        </div>

        <?php if ($recipe->more): ?>
            <div class="cook-more clearfix">
                <div class="cook-more_top">
                    Еще вкусненькое
                </div>
                <ul class="cook-more_ul clearfix">
                    <?php foreach ($recipe->more as $m): ?>
                        <li class="cook-more_li">
                            <div class="cook-more_author clearfix">
                                <?php $this->widget('Avatar', array('user' => $recipe->author, 'size' => 24)) ?>
                                <div class="clearfix">
                                    <a class="textdec-onhover" href="<?=$m->author->getUrl() ?>"><?=$m->author->getFullName() ?></a>
                                    <div class="color-gray font-smallest"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $m->created)?></div>
                                </div>
                            </div>
                            <?php if ($m->mainPhoto): ?>
                                <div class="cook-more_cnt">
                                    <?=CHtml::link(CHtml::image($m->getPreview(120, 105)), $m->url)?>
                                </div>
                            <?php endif; ?>
                            <div class="cook-more_t"><?=CHtml::link($m->title, $m->url)?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $recipe, 'full' => true)); ?>
    </div>
</div>

<script type="text/javascript">
    var RecipeViewModel = function() {
        var self = this;
        self.SHOW_NUTRITIONS_100G = 0;
        self.SHOW_NUTRITIONS_SERVING = 1;
        self.showNutritions = ko.observable(false);

        self.rootNutritionHandler = function() {
            if (self.showNutritions() === false)
                self.showNutritions(self.SHOW_NUTRITIONS_100G)
            else
                self.showNutritions(false);
        }

        self.setNutrition = function(value) {
            self.showNutritions(value);
        }
    }

    recipeVM = new RecipeViewModel();
    ko.applyBindings(recipeVM, document.getElementById('recipe'));
</script>