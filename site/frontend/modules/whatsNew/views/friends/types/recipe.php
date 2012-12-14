<?php
    $this->widget('site.frontend.widgets.photoView.photoViewWidget', array(
        'selector' => '.masonry-news-list_item:data(id=' . $data->blockId . ') .title-img a',
        'entity' => 'CookRecipe',
        'entity_id' => $data->recipe->id,
        'entity_url' => $data->recipe->url,
    ));
?>

<h3 class="masonry-news-list_title">
    <?=CHtml::link($data->recipe->title, $data->recipe->url)?>
</h3>
<div class="masonry-news-list_content">
    <?php if ($data->recipe->mainPhoto !== null): ?>
        <div class="title-img">
            <?=CHtml::link(CHtml::image($data->recipe->mainPhoto->getPreviewUrl(198, null, Image::WIDTH), $data->recipe->title), 'javascript:void(0)', array('data-id' => $data->recipe->mainPhoto->id))?>
            <span class="btn-view">Посмотреть</span>
        </div>
    <?php endif; ?>
    <p><?=Str::truncate($data->recipe->text, 256)?> <a href="<?=$data->recipe->url?>" class="all">Весь рецепт</a></p>
</div>

<div class="masonry-news-list_meta-info clearfix">
    <?php $this->renderPartial('application.modules.whatsNew.views._meta', array('model' => $data->recipe)); ?>

    <a href="<?=$data->recipe->getUrl(true)?>" class="textdec-onhover">Добавить <br />комментарий</a>
</div>