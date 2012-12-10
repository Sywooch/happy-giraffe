<?php
    $image = $data->content->getContentImage(198);
?>

<h3 class="masonry-news-list_title">
    <?=CHtml::link($data->content->title, $data->content->url)?>
</h3>
<?php if (! $data->content->isFromBlog): ?>
    <div class="clearfix">
        <a href="<?=$data->content->rubric->community->url?>" class="club-category <?=$data->content->rubric->community->css_class?>"><?=$data->content->rubric->community->shortTitle?></a>
    </div>
<?php else: ?>
    <div class="clearfix">
        <span class="sub-category"><span class="icon-blog"></span>Личный блог</span>
    </div>
<?php endif; ?>
<div class="masonry-news-list_content">
    <?php if (! empty($image)): ?>
        <?=CHtml::link(CHtml::image($image, $data->content->title), $data->content->url)?>
    <?php endif; ?>
    <p><?=Str::truncate($data->content->content->text, 256)?> <a href="<?=$data->content->url?>" class="all">Читать</a></p>
</div>

<div class="masonry-news-list_meta-info clearfix">
    <?php $this->renderPartial('/_meta', array('model' => $data->content)); ?>

    <a href="<?=$data->content->getUrl(true)?>" class="textdec-onhover">Добавить <br />комментарий</a>
</div>