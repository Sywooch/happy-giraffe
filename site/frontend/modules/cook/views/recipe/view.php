<?php
if (empty($this->meta_description))
    $this->meta_description = Str::getDescription($recipe->text, 300);

?><div class="b-article clearfix" id="recipe">
    <?php $this->renderPartial('_recipe_parts/_controls', array('recipe' => $recipe)); ?>
    <!-- hrecipe -->
    <div class="b-article_cont hrecipe clearfix">
        <?php $this->renderPartial('_recipe_parts/_header', array('recipe' => $recipe, 'full' => true)); ?>
        <!-- Название блюда должно иметь класс fn  для микроформатов -->
        <h1 class="b-article_t fn">
            <?=$recipe->title?>
            <?php $this->widget('site.frontend.widgets.favoritesWidget.FavouritesWidget', array('model' => $recipe)); ?>
        </h1>

        <?php $this->renderPartial('//banners/_post_header', array('data' => $recipe)); ?>

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
                        <a class="nutrition_t a-pseudo" data-bind="click: rootNutritionHandler">Калорийность блюда - <?=$recipe->getTotalCalories()?> ккал</a>

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
                <div class="instructions">
                    <?=$recipe->purified->text?>
                </div>
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

        <?php $this->renderPartial('//banners/_post_footer', array('data' => $recipe)); ?>

        <noindex>
            <?php if (! Yii::app()->user->checkAccess('tester')): ?>
                <?php $this->widget('site.frontend.widgets.socialLike.SocialLikeWidget', array(
                    'model' => $recipe,
                    'type' => 'simple',
                    'options' => array(
                        'title' => $recipe->title,
                        'image' => $recipe->getContentImage(400),
                        'description' => $recipe->text,
                    ),
                )); ?>
            <?php else: ?>
                <div style="text-align: center; margin-bottom: 10px;">
                    <?php $this->widget('application.widgets.yandexShareWidget.YandexShareWidget', array('model' => $recipe)); ?>
                </div>
            <?php endif; ?>
        </noindex>

    </div>
</div>


        <table class="article-nearby clearfix" ellpadding="0" cellspacing="0">
            <tr>
                <td>
                    <?php if ($recipe->prev): ?>
                    <div class="article-nearby_hint">Предыдущая запись</div>
                    <?php endif; ?>
                </td>
                <td class="article-nearby_r">
                    <?php if ($recipe->next): ?>
                    <div class="article-nearby_hint">Следующая запись</div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php if ($recipe->prev): ?>
                    <a href="<?=$recipe->prev->url?>" class="article-nearby_a clearfix">
                        <span class="article-nearby_tx"><?=$recipe->prev->title?></span>
                    </a>
                    <?php endif; ?>
                </td>
                <td class="article-nearby_r">
                    <?php if ($recipe->next): ?>
                    <a href="<?=$recipe->next->url?>" class="article-nearby_a clearfix">
                        <span class="article-nearby_tx"><?=$recipe->next->title?></span>
                    </a>
                    <?php endif; ?>
                </td>
            </tr>
        </table>


        <?php if ($recipe->more): ?>
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
            </noindex>
        <?php endif; ?>

        <?php $this->renderPartial('//banners/_article_banner', array('data' => $recipe)); ?>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('entity' => 'CookRecipe', 'entity_id' => $recipe->primaryKey, 'full' => true)); ?>

<?php $this->widget('application.widgets.seo.SeoLinksWidget'); ?>

<script type="text/javascript">
    var RecipeViewModel = function(data) {
        var self = this;
        self.SHOW_NUTRITIONS_100G = 0;
        self.SHOW_NUTRITIONS_SERVING = 1;
        self.showNutritions = ko.observable(false);
        self.hasServings = data.hasServings;

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

    recipeVM = new RecipeViewModel(<?=CJSON::encode(array('hasServings' => $recipe->servings !== null))?>);
    ko.applyBindings(recipeVM, document.getElementById('recipe'));
</script>
