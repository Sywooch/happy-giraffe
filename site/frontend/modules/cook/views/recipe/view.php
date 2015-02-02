<?php
if (empty($this->meta_description))
    $this->meta_description = Str::getDescription($recipe->text, 300);
$comments = $this->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
        'entity' => 'CookRecipe',
        'entity_id' => $recipe->id,
        )));
?>
<article class="b-article hrecipe clearfix" id="recipe">
    <?php /* $this->renderPartial('_recipe_parts/_controls', array('recipe' => $recipe)); */ ?>
    <!-- hrecipe -->
    <div class="b-article_cont hrecipe clearfix">
        <div class="b-article_cont clearfix">
            <div class="b-article_header clearfix">
                <div class="b-article_header clearfix">
                    <div class="float-l">
                        <!-- ava-->
                        <a href="<?= $recipe->author->getUrl() ?>" class="ava ava__female ava__small-xxs ava__middle-xs ava__middle-sm-mid ">
                            <span class="ico-status ico-status__online"></span>
                            <img alt="" src="<?= $recipe->author->getAvatarUrl(72); ?>" class="ava_img">
                        </a>
                        <a href="#" class="b-article_author"><?= $recipe->author->getFullName() ?></a>
                        <?= HHtml::timeTag($recipe, array('class' => 'tx-date'), ''); ?>
                    </div>
                    <div class="icons-meta"><a href="#commentsList" class="icons-meta_comment"><span class="icons-meta_tx"><?= $comments->count ?></span></a>
                        <div class="icons-meta_view"><span class="icons-meta_tx"><?= $this->getViews() ?></span></div>
                    </div>
                </div>
            </div>
            <!-- Название блюда должно иметь класс fn  для микроформатов -->
            <h1 class="b-article_t fn">
                <?= $recipe->title ?>
            </h1>

            <?php $this->renderPartial('//banners/_post_header', array('data' => $recipe)); ?>

            <div class="b-article_in clearfix">
                <div class="wysiwyg-content clearfix">
                    <?php if ($recipe->mainPhoto !== null): ?>
                        <div class="b-article_in-img">
                            <?= CHtml::image($recipe->mainPhoto->getPreviewUrl(580, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'content-img')) ?>
                        </div>
                    <?php else: ?>
                        <br>
                    <?php endif; ?>

                <!-- Всталвять или после изображения или после <br> или пустого <p> -->
                    <div class="recipe-desc clearfix">
                        <?php if ($recipe->cuisine): ?>
                            <div class="location clearfix">
                                <?php if (!empty($recipe->cuisine->country_id)): ?>
                                    <span class="flag-big flag-big-<?= $recipe->cuisine->country->iso_code ?>"></span>
                                <?php endif; ?>
                                <span class="location_tx"><?= $recipe->cuisine->title ?></span>
                            </div>
                        <?php endif; ?>
                        <?php if ($recipe->preparation_duration || $recipe->cooking_duration): ?>
                            <div class="recipe-desc_holder">
                                <?php if ($recipe->preparation_duration): ?>
                                    <div class="recipe-desc_i">
                                        <div class="recipe-desc_ico recipe-desc_ico__time-1 powertip" title="Время подготовки"></div>
                                        <?= $recipe->preparation_duration_h ?> : <?= $recipe->preparation_duration_m ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($recipe->cooking_duration): ?>
                                    <div class="recipe-desc_i">
                                        <div class="recipe-desc_ico recipe-desc_ico__time-2 powertip" title="Время приготовления"></div>
                                        <?= $recipe->cooking_duration_h ?> : <?= $recipe->cooking_duration_m ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($recipe->servings): ?>
                            <div class="recipe-desc_i">
                                <div class="recipe-desc_ico recipe-desc_ico__yield powertip" title="Количество порций"></div>
                                на <span class="yeild"><?= $recipe->servings ?> <?= Str::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings) ?></span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="clearfix">
                        <div class="nutrition float-r">
                            <a class="nutrition_t a-pseudo" data-bind="click: rootNutritionHandler">Калорийность блюда - <?= $recipe->getTotalCalories() ?> ккал</a>

                            <div class="nutrition_hold" data-bind="css: { 'display-b' : showNutritions() !== false }">
                                <div class="nutrition_portion">
                                    <a class="nutrition_portion-a" data-bind="css: { active : showNutritions() == SHOW_NUTRITIONS_100G }, click: function(data, event) { setNutrition(SHOW_NUTRITIONS_100G, data, event) }">На 100 г</a>
                                    <a class="nutrition_portion-a" data-bind="css: { active : showNutritions() == SHOW_NUTRITIONS_SERVING, disabled : ! hasServings }, click: function(data, event) { if (hasServings) setNutrition(SHOW_NUTRITIONS_SERVING, data, event) }">На порцию</a>
                                </div>
                                <ul class="nutrition_ul" data-bind="visible: showNutritions() == SHOW_NUTRITIONS_100G">
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__calories">
                                            <i>К</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Калории -
                                            <span class="calories"><?= $recipe->getNutritionalsPer100g(1) ?></span>
                                            <span class="nutrition_measure">ккал.</span>
                                        </div>
                                    </li>
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__protein">
                                            <i>Б</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Белки -
                                            <span class="protein"><?= $recipe->getNutritionalsPer100g(3) ?></span>
                                            <span class="nutrition_measure">г.</span>
                                        </div>
                                    </li>
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__fat">
                                            <i>Ж</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Жиры -
                                            <span class="fat"><?= $recipe->getNutritionalsPer100g(2) ?></span>
                                            <span class="nutrition_measure">г.</span>
                                        </div>
                                    </li>
                                    <li class="nutrition_li">
                                        <div class="nutrition_icon nutrition_icon__carbohydrates">
                                            <i>У</i>
                                        </div>
                                        <div class="nutrition_tx">
                                            Углеводы -
                                            <span class="carbohydrates"><?= $recipe->getNutritionalsPer100g(4) ?></span>
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
                                                <span class="calories"><?= $recipe->getNutritionalsPerServing(1) ?></span>
                                                <span class="nutrition_measure">ккал.</span>
                                            </div>
                                        </li>
                                        <li class="nutrition_li">
                                            <div class="nutrition_icon nutrition_icon__protein">
                                                <i>Б</i>
                                            </div>
                                            <div class="nutrition_tx">
                                                Белки -
                                                <span class="protein"><?= $recipe->getNutritionalsPerServing(3) ?></span>
                                                <span class="nutrition_measure">см.</span>
                                            </div>
                                        </li>
                                        <li class="nutrition_li">
                                            <div class="nutrition_icon nutrition_icon__fat">
                                                <i>Ж</i>
                                            </div>
                                            <div class="nutrition_tx">
                                                Жиры -
                                                <span class="fat"><?= $recipe->getNutritionalsPerServing(2) ?></span>
                                                <span class="nutrition_measure">г.</span>
                                            </div>
                                        </li>
                                        <li class="nutrition_li">
                                            <div class="nutrition_icon nutrition_icon__carbohydrates">
                                                <i>У</i>
                                            </div>
                                            <div class="nutrition_tx">
                                                Углеводы -
                                                <span class="carbohydrates"><?= $recipe->getNutritionalsPerServing(4) ?></span>
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
                                        <span class="name"><?= $i->ingredient->title ?></span>
                                        - <span class="amount">
                                            <?php if ($i->unit->type != 'undefined'): ?><?= $i->display_value ?>&nbsp;<?php endif; ?><?= $i->noun ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>


                    <h2 class="wysiwyg-content_t-sub">Приготовление</h2>
                    <div class="instructions">
                        <?= $recipe->purified->text ?>
                    </div>
                </div>
                <div class="clearfix">
                    <?php if ($recipe->servings): ?>
                        <div class="cook-diabets">
                            <div class="cook-diabets-chart <?= $recipe->getBakeryItemsCssClass() ?>">
                                <span class="text"><?= $recipe->bakeryItems ?></span>
                            </div>
                            <div class="cook-diabets-desc"><?= $recipe->getBakeryItemsText() ?></div>
                        </div>
                    <?php endif; ?>

                    <?php $tags = $recipe->getNotEmptyTags(); ?>
                    <?php if ($tags): ?>
                        <div class="cook-article-tags">
                            <div class="cook-article-tags-title">Теги</div>
                            <ul class="cook-article-tags-list">
                                <?php foreach ($tags as $tag): ?>
                                    <li><a href="<?= $tag->getUrl() ?>"><?= strip_tags($tag->title) ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $recipe, 'lite' => true)); ?>

            <!-- Реклама яндекса-->
            <?php $this->renderPartial('//banners/_direct_others'); ?>
        </div>
    </div>

</article>

<table class="article-nearby clearfix">
    <tr>
        <td><?= $recipe->prev ? '<a href="' . $recipe->prev->url . '" class="article-nearby_a article-nearby_a__l" rel="prev"><span class="article-nearby_tx">' . $recipe->prev->title . '</span></a>' : '&nbsp;' ?></td>
        <td><?= $recipe->next ? '<a href="' . $recipe->next->url . '" class="article-nearby_a article-nearby_a__r" rel="next"><span class="article-nearby_tx">' . $recipe->next->title . '</span></a>' : '&nbsp;' ?></td>
    </tr>
</table>

<?php /* if ($recipe->more): ?>
  <noindex>
  <div class="cook-more clearfix">
  <div class="cook-more_top">
  Еще вкусненькое
  </div>
  <ul class="cook-more_ul clearfix">
  <?php foreach ($recipe->more as $m): ?>
  <li class="cook-more_li">
  <div class="cook-more_author clearfix">
  <?php $this->widget('Avatar', array('user' => $m->author, 'size' => 24)) ?>
  <div class="clearfix">
  <a class="textdec-onhover" href="<?= $m->author->getUrl() ?>"><?= $m->author->getFullName() ?></a>
  <div class="color-gray font-smallest"><?= Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $m->created) ?></div>
  </div>
  </div>
  <?php if ($m->mainPhoto): ?>
  <div class="cook-more_cnt">
  <?= CHtml::link(CHtml::image($m->getPreview(120, 105)), $m->url) ?>
  </div>
  <?php endif; ?>
  <div class="cook-more_t"><?= CHtml::link($m->title, $m->url) ?></div>
  </li>
  <?php endforeach; ?>
  </ul>
  </div>
  </noindex>
  <?php endif; */ ?>

<?php $this->renderPartial('//banners/_article_banner', array('data' => $recipe)); ?>

<section class="comments comments__buble">
    <div class="comments-menu">
        <ul data-tabs="tabs" class="comments-menu_ul">
            <li class="comments-menu_li active"><a href="#commentsList" data-toggle="tab" class="comments-menu_a comments-menu_a__comments">Комментарии <?= $comments->count ?> </a></li>
            <!--<li class="comments-menu_li"><a href="#likesList" data-toggle="tab" class="comments-menu_a comments-menu_a__likes">Нравится 865</a></li>
            <li class="comments-menu_li"><a href="#favoritesList" data-toggle="tab" class="comments-menu_a comments-menu_a__favorites">Закладки 865</a></li>-->
        </ul>
    </div>
    <div class="tab-content">
        <?php $comments->run(); ?>
        <!--<div id="likesList" class="comments_hold tab-pane">
            <div class="list-subsribe-users">
                <ul class="list-subsribe-users_ul">
                    <li class="list-subsribe-users_li">
                        <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                        <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                    </li>
                    <li class="list-subsribe-users_li">
                        <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                        <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="favoritesList" class="comments_hold tab-pane">
            <div class="list-subsribe-users">
                <ul class="list-subsribe-users_ul">
                    <li class="list-subsribe-users_li">
                        <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                        <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-success btn-sl"><span class="ico-plus"></span>Подписаться</a>
                    </li>
                    <li class="list-subsribe-users_li">
                        <a href="#" class="ava ava__middle"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" class="ava_img"></a><a class="a-light">Ангелина Богоявленская</a>
                        <time datetime="1957-10-04" class="tx-date">Сегодня 13:25</time><a class="btn btn-secondary btn-sl">Читаю</a>
                    </li>
                </ul>
            </div>
        </div>-->
    </div>
</section>

<?php $this->widget('application.widgets.seo.SeoLinksWidget'); ?>

<script type="text/javascript">
    require(['knockout'], function (ko) {
        var RecipeViewModel = function (data) {
            var self = this;
            self.SHOW_NUTRITIONS_100G = 0;
            self.SHOW_NUTRITIONS_SERVING = 1;
            self.showNutritions = ko.observable(false);
            self.hasServings = data.hasServings;

            self.rootNutritionHandler = function () {
                if (self.showNutritions() === false)
                    self.showNutritions(self.SHOW_NUTRITIONS_100G)
                else
                    self.showNutritions(false);
            }

            self.setNutrition = function (value) {
                self.showNutritions(value);
            }
        }

        recipeVM = new RecipeViewModel(<?= CJSON::encode(array('hasServings' => $recipe->servings !== null)) ?>);
        var recipeCointainer = document.getElementById('recipe');
        ko.cleanNode(recipeCointainer);
        ko.applyBindings(recipeVM, recipeCointainer);
    });
</script>
