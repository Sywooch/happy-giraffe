<div class="masonry-news-list_comment">
    <div class="masonry-news-list_comment-text">
        <a href="<?=$data->comment->url?>"><?=Str::truncate($data->comment->text, 512)?></a>
    </div>
</div>

<?php if (in_array(get_class($data->relatedModel), array('CommunityContent', 'BlogContent'))): ?>
    <?php if (($to = $data->getToString()) !== false): ?>
        <div class="masonry-news-list_meta-info clearfix"><?=$to?></div>
    <?php endif; ?>
    <h3 class="masonry-news-list_title">
        <?=CHtml::link($data->relatedModel->title, $data->relatedModel->url)?>
    </h3>
<?php elseif (get_class($data->relatedModel) == 'CookRecipe'): ?>
    <h3 class="masonry-news-list_title">
        <?=CHtml::link($data->relatedModel->title, $data->relatedModel->url)?>
    </h3>
    <div class="clearfix">
        <span class="sub-category"><span class="icon-cook"></span>Кулинарный рецепт</span>
    </div>
<?php elseif (get_class($data->relatedModel) == 'Service'): ?>

<?php endif; ?>

<div class="masonry-news-list_meta-info clearfix">

    <?php $this->renderPartial('application.modules.whatsNew.views._meta', array('model' => $data->comment->relatedModel)); ?>

    <a href="<?=$data->relatedModel->getUrl(true)?>" class="textdec-onhover">Вступить <br />в беседу!</a>
</div>