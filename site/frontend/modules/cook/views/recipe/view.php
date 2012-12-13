<?
    /**
     * @var CookRecipe $recipe
     */

    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => 'div.big > a, div.thumbs a:not(.add)',
        'entity' => 'CookRecipe',
        'entity_id' => $recipe->id,
    ));

    $cs = Yii::app()->clientScript;

    $js = "
        function toggleNutrition(el, nutrition)
        {
            $('div.portion > a.active').removeClass('active');
            $(el).addClass('active');
            $('div.nutrition:first > ul:visible').hide();
            $('div.nutrition:first > ul.' + nutrition).show();
        }
    ";

    if (Yii::app()->request->getParam('Comment_page', null) !== null) {
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
    }

    $cs->registerScript('cookRecipeView', $js, CClientScript::POS_HEAD);
    if (empty($this->meta_description))
        $this->meta_description = trim(Str::truncate(strip_tags($recipe->text), 300));
?>
<div class="entry hrecipe clearfix">

    <h1 class="fn"><?=$recipe->title?></h1>

    <div class="entry-header clearfix">

        <?php
            $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $recipe->author,
                'friendButton' => true,
                'location' => false,
            ));
        ?>

        <div class="meta">
            <div class="time"><?=Yii::app()->dateFormatter->format("d MMMM yyyy, H:mm", $recipe->created)?></div>
            <div class="seen">Просмотров:&nbsp;<span><?=$this->getViews()?></span></div><br>
            <a href="<?=$recipe->getUrl(true)?>">Комментариев: <?= $recipe->commentsCount; ?></a>
        </div>

    </div>

    <div class="entry-content">

        <div class="recipe-right">

            <div class="recipe-description">

                <?php if ($recipe->cuisine || $recipe->preparation_duration || $recipe->cooking_duration || $recipe->servings): ?>
                    <ul>
                        <?php if ($recipe->cuisine): ?>
                            <li>Кухня <span class="nationality"><!--<div class="flag flag-ua"></div> --><span class="cuisine-type"><?=$recipe->cuisine->title?></span></span></li>
                        <?php endif; ?>
                        <?php if ($recipe->preparation_duration): ?>
                            <li>Время подготовки <span class="time-1"><i class="icon"></i><span class=""><?=$recipe->preparation_duration_h?> : <?=$recipe->preparation_duration_m?></span></span></li>
                        <?php endif; ?>
                        <?php if ($recipe->cooking_duration): ?>
                            <li>Время приготовления <span class="time-2"><i class="icon"></i><span class=""><?=$recipe->cooking_duration_h?> : <?=$recipe->cooking_duration_m?></span></span></li>
                        <?php endif; ?>
                        <?php if ($recipe->servings): ?>
                            <li>Кол-во порций <span class="yield-count"><i class="icon"></i><span class="yield"><?=$recipe->servings?> <?=HDate::GenerateNoun(array('персона', 'персоны', 'персон'), $recipe->servings)?></span></span></li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>

                <div class="actions">

                    <!--<div class="action">
                        <a href="" class="print"><i class="icon"></i>Распечатать</a>
                    </div>

                    <div class="action">
                        <a href="" class="add-to-cookbook"><i class="icon"></i>Добавить в кулинарную книгу</a>
                    </div>-->

                    <div class="action share">
                        <script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script>
                        Поделиться
                        <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"></div>
                    </div>


                </div>

                <?php $this->renderPartial('_recipe_tags_edit',array('recipe'=>$recipe)); ?>

            </div>

            <?php if ($recipe->ingredients): ?>
                <div class="nutrition">

                    <div class="block-title">Калорийность блюда</div>

                    <div class="portion">
                        <a onclick="toggleNutrition(this, 'g100');" href="javascript:void(0)" class="active">На 100 г.</a>
                        |
                        <?php if ($recipe->servings !== null): ?>
                            <a onclick="toggleNutrition(this, 'total');" href="javascript:void(0)">На порцию</a>
                        <?php else: ?>
                            <a class="disabled" href="javascript:void(0)">На порцию</a>
                        <?php endif; ?>
                    </div>

                    <ul class="g100">
                        <li class="n-calories">
                            <div class="icon">
                                <i>К</i>
                                Калории
                            </div>
                            <span class="calories"><?=$recipe->getNutritionalsPer100g(1)?></span> <span class="gray">ккал.</span>
                        </li>
                        <li class="n-protein">
                            <div class="icon">
                                <i>Б</i>
                                Белки
                            </div>
                            <span class="protein"><?=$recipe->getNutritionalsPer100g(3)?></span> <span class="gray">г.</span>
                        </li>
                        <li class="n-fat">
                            <div class="icon">
                                <i>Ж</i>
                                Жиры
                            </div>
                            <span class="fat"><?=$recipe->getNutritionalsPer100g(2)?></span> <span class="gray">г.</span>
                        </li>
                        <li class="n-carbohydrates">
                            <div class="icon">
                                <i>У</i>
                                Углеводы
                            </div>
                            <span class="carbohydrates"><?=$recipe->getNutritionalsPer100g(4)?></span> <span class="gray">г.</span>
                        </li>

                    </ul>

                    <?php if ($recipe->servings !== null): ?>
                        <ul class="total" style="display:none;">
                            <li class="n-calories">
                                <div class="icon">
                                    <i>К</i>
                                    Калории
                                </div>
                                <span class="calories"><?=$recipe->getNutritionalsPerServing(1)?></span> <span class="gray">ккал.</span>
                            </li>
                            <li class="n-protein">
                                <div class="icon">
                                    <i>Б</i>
                                    Белки
                                </div>
                                <span class="protein"><?=$recipe->getNutritionalsPerServing(3)?></span> <span class="gray">г.</span>
                            </li>
                            <li class="n-fat">
                                <div class="icon">
                                    <i>Ж</i>
                                    Жиры
                                </div>
                                <span class="fat"><?=$recipe->getNutritionalsPerServing(2)?></span> <span class="gray">г.</span>
                            </li>
                            <li class="n-carbohydrates">
                                <div class="icon">
                                    <i>У</i>
                                    Углеводы
                                </div>
                                <span class="carbohydrates"><?=$recipe->getNutritionalsPerServing(4)?></span> <span class="gray">г.</span>
                            </li>

                        </ul>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php if ($recipe->forDiabetics): ?>
                <div class="nutrition diabetes">

                    <div class="block-title">Подходит для диабетиков</div>

                    <ul>
                        <li class="n-bread">
                            <div class="icon">
                                <i>ХЕ</i>
                                Хлебных единиц
                            </div>
                            <span class="calories"><?=$recipe->bakeryItems?></span> <span class="gray">х.е.</span>
                        </li>
                    </ul>


                </div>
            <?php endif; ?>

        </div>

        <div class="recipe-photo">

            <?php if ($recipe->mainPhoto === null): ?>
                <?php
                    $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                        'entity' => get_parent_class($recipe),
                        'entity_id' => $recipe->id,
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
                    <a href="javascript:void(0)" data-id="<?=$recipe->mainPhoto->id?>">
                        <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(441, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'photo'))?>
                    </a>
                </div>
            <?php endif; ?>

            <div class="thumbs clearfix">

                <ul>
                    <?php foreach ($recipe->thumbs as $t): ?>
                        <li><a href="javascript:void(0)" data-id="<?=$t->photo->id?>"><?=CHtml::image($t->photo->getPreviewUrl(78, 52, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP), $t->photo->title)?></a></li>
                    <?php endforeach; ?>
                    <?php if ($recipe->mainPhoto !== null): ?>
                        <li>
                            <?php
                                $this->beginWidget('application.widgets.fileAttach.FileAttachWidget', array(
                                    'entity' => get_parent_class($recipe),
                                    'entity_id' => $recipe->id,
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

        <?php if ($recipe->ingredients): ?>
            <h2>Ингредиенты</h2>

            <ul class="ingredients">
                <?php foreach ($recipe->ingredients as $i): ?>
                    <li class="ingredient">
                        <span class="name"><?=$i->ingredient->title?></span>
                        <?php if ($i->unit->type != 'undefined'): ?>
                            <span class="value"><?=$i->display_value?></span>
                        <?php endif; ?>
                        <span class="type"><?=$i->noun?></span>
                        <!--<a href="" class="calculator-trigger tooltip" title="Открыть калькулятор мер"></a>-->
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <h2>Приготовление</h2>

        <div class="instructions wysiwyg-content">

            <?=$recipe->purified->text?>

        </div>

    </div>

    <div class="entry-footer">
        <div class="admin-actions">
            <?php if (Yii::app()->authManager->checkAccess('editCookRecipe', Yii::app()->user->id) || Yii::app()->user->id == $recipe->author_id){
                echo CHtml::link('<i class="icon"></i>', $this->createUrl('/cook/recipe/form/', array('id' => $recipe->id, 'section' => $recipe->section)), array('class' => 'edit'));
            } ?>
        </div>
    </div>
</div>

<?php if ($recipe->more): ?>
    <div class="cook-more clearfix">
        <div class="block-title">
            Еще вкусненькое
        </div>
        <ul>
            <?php foreach ($recipe->more as $m): ?>
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

<?php
    $this->widget('application.widgets.commentWidget.CommentWidget', array(
        'entity' => get_parent_class($recipe),
        'entity_id' => $recipe->primaryKey,
    ));
    $remove_tmpl = $this->beginWidget('site.frontend.widgets.removeWidget.RemoveWidget');
    $remove_tmpl->registerTemplates();
    $this->endWidget();
?>

<?php
    $this->widget('application.widgets.seo.SeoLinksWidget');
    $this->widget('WhatsNewWidget');
?>