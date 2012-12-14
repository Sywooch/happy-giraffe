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
    <?php $this->renderPartial('application.modules.whatsNew.views._post_content', array('post' => $data->content, 'blockId' => $data->blockId)); ?>
</div>

<div class="masonry-news-list_meta-info clearfix">
    <?php $this->renderPartial('application.modules.whatsNew.views._meta', array('model' => $data->content)); ?>

    <a href="<?=$data->content->getUrl(true)?>" class="textdec-onhover">Добавить <br />комментарий</a>
</div>