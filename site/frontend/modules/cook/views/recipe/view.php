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

<div class="entry hrecipe recipe-article clearfix">

<?php $this->renderPartial('_recipe_parts/_header',array('recipe'=>$recipe)); ?>

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
    <a href="" class="add-photo">
        <i class="icon"></i>
        <span>Вы уже готовили это блюдо?<br>Добавьте фото!</span>
    </a>
    <?php $this->endWidget();?>
    <?php else: ?>
    <div class="big">
        <a href="javascript:void(0)" data-id="<?=$recipe->mainPhoto->id?>">
            <?=CHtml::image($recipe->mainPhoto->getPreviewUrl(460, null, Image::WIDTH), $recipe->mainPhoto->title, array('class' => 'photo'))?>
        </a>
    </div>
    <?php endif; ?>

    <div class="thumbs clearfix">

        <ul class="clearfix">
            <?php if ($recipe->mainPhoto !== null):?>
                <li>
                    <a href="javascript:;" class="add" data-id="<?=$recipe->mainPhoto->id?>"><?=CHtml::image($recipe->mainPhoto->getPreviewUrl(78, 52, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP), $recipe->mainPhoto->title)?></a>
                </li>
                <?php foreach ($recipe->thumbs as $t): ?>
                    <li><a href="javascript:;" data-id="<?=$t->photo->id?>"><?=CHtml::image($t->photo->getPreviewUrl(82, 60, Image::WIDTH, true, AlbumPhoto::CROP_SIDE_TOP), $t->photo->title)?></a></li>
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
            <a href="javascript:;" data-id="<?=$recipe->thumbs[0]->id?>">Смотреть еще <?=count($recipe->attachPhotos) - 4 ?> фото</a>
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

<div class="instructions wysiwyg-content">

    <?=$recipe->purified->text?>

    <div class="clearfix">

        <?php $this->renderPartial('_recipe_parts/_diabetics', array('recipe' => $recipe)); ?>

        <?php $this->renderPartial('_recipe_parts/_tags', array('recipe' => $recipe)); ?>

    </div>

    <?php $this->renderPartial('_recipe_parts/_recipe_tags_edit',array('recipe'=>$recipe)); ?>

</div>

</div>

</div>

<?php $this->renderPartial('_recipe_parts/_more',array('recipe'=>$recipe)); ?>

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
