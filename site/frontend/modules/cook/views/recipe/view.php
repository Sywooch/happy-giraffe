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

    if (Yii::app()->request->getParam('Comment_page', null) !== null)
        Yii::app()->clientScript->registerMetaTag('noindex', 'robots');

    $cs->registerScript('cookRecipeView', $js, CClientScript::POS_HEAD);
    if (empty($this->meta_description))
        $this->meta_description = Str::getDescription($recipe->text, 300);
?>

<div class="entry hrecipe recipe-article clearfix">

<?php $this->renderPartial('_recipe_parts/_header',array('recipe'=>$recipe, 'full'=>true)); ?>

<div class="entry-content">

    <?php $this->renderPartial('_recipe_parts/_cook_book', array('recipe' => $recipe)); ?>

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
        <span>Вы уже готовили это блюдо?<br>Добавьте фото!</span>
    <?php $this->endWidget();?>
    <?php else: ?>
    <div class="big">
        <a href="javascript:void(0)" data-id="<?=$recipe->mainPhoto->id?>">
            <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(460, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'photo result-photo'))?>
        </a>
    </div>
    <?php endif; ?>

    <div class="thumbs clearfix">

        <ul class="clearfix">
            <?php if ($recipe->mainPhoto !== null):?>
                <li>
                    <a href="javascript:;" class="add" data-id="<?=$recipe->mainPhoto->id?>"><?=CHtml::image($recipe->mainPhoto->getPreviewUrl(82, 60, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_CENTER), $recipe->mainPhoto->title)?></a>
                </li>
                <?php foreach ($recipe->thumbs as $t): ?>
                    <li><a href="javascript:;" data-id="<?=$t->photo->id?>"><?=CHtml::image($t->photo->getPreviewUrl(82, 60, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_CENTER), $t->photo->title)?></a></li>
                <?php endforeach; ?>
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
                    <span>Уже готовили</span>
                    <i class="icon"></i>
                    <span class="blue">Поделитесь <br> фото!</span>
                    <?php $this->endWidget() ?>
                </li>
            <?php endif; ?>
        </ul>
        <?php if (count($recipe->attachPhotos) > 3):?>
            <a href="javascript:;" data-id="<?=$recipe->attachPhotos[3]->photo->id?>">Смотреть еще <?=count($recipe->attachPhotos) - 3 ?> фото</a>
        <?php endif ?>
    </div>

</div>

<div style="clear:left;"></div>

    <?php $this->renderPartial('_recipe_parts/_recipe_description', array('recipe' => $recipe)); ?>

<div class="clearfix">
    <div class="recipe-right">

        <?php $this->renderPartial('_recipe_parts/_calories', array('recipe' => $recipe)); ?>

    </div>

    <?php $this->renderPartial('_recipe_parts/_ingredients', array('recipe' => $recipe)); ?>
</div>

<h2>Приготовление</h2>

<div class="cook-instructions">

    <div class="instructions wysiwyg-content">
        <?=$recipe->purified->text?>
    </div>

    <div class="clearfix">

        <?php $this->renderPartial('_recipe_parts/_diabetics', array('recipe' => $recipe)); ?>

        <?php $this->renderPartial('_recipe_parts/_tags', array('recipe' => $recipe, 'full'=>true)); ?>

    </div>

    <?php $this->renderPartial('_recipe_parts/_recipe_tags_edit',array('recipe'=>$recipe)); ?>

</div>

</div>

</div>

<?php $this->renderPartial('_recipe_parts/_more',array('recipe'=>$recipe)); ?>

<div style="margin-top: 40px; margin-bottom: 40px;">
    <!-- Яндекс.Директ -->
    <div id="yandex_ad_2"></div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Direct.insertInto(87026, "yandex_ad_2", {
                    stat_id: 2,
                    site_charset: "utf-8",
                    ad_format: "direct",
                    font_size: 1,
                    type: "horizontal",
                    limit: 3,
                    title_font_size: 3,
                    site_bg_color: "FFFFFF",
                    header_bg_color: "FEEAC7",
                    title_color: "0000CC",
                    url_color: "006600",
                    text_color: "000000",
                    hover_color: "0066FF",
                    favicon: true
                });
            });
            t = d.getElementsByTagName('head')[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "http://an.yandex.ru/system/context.js";
            s.setAttribute("async", "true");
            t.insertBefore(s, t.firstChild);
        })(window, document, "yandex_context_callbacks");
    </script>
</div>

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
?>
