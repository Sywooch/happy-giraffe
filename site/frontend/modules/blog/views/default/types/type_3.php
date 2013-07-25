<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

$post = $data->photoPost;
?>
<?php if ($full):?>
    <h2 class="b-article_t">
        <?=$data->title ?>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=$data->photoPost->text ?></p>
        </div>
    </div>
<?php else: ?>
    <h2 class="b-article_t">
        <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=strip_tags($post->text) ?></p>
            <div class="b-article_in-img">
                <img src="<?=$post->photo->getPreviewUrl(580, 1000, Image::WIDTH) ?>" class="content-img">
            </div>
        </div>
    </div>

    <div class="textalign-r margin-15">
        <a href="<?=$data->getUrl() ?>" class="b-article_more">Смотреть далее</a>
    </div>
<?php endif ?>