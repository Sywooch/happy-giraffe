<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

$post = $data->post;
$photo = $data->getPhoto()
?>
<?php if ($full):?>
    <h2 class="b-article_t">
        <?=$data->title ?>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <?=$data->post->purified->text ?>
        </div>
    </div>
    <?php if ($data->gallery !== null) $this->renderPartial('photo_gallery', array('data' => $data)); ?>
<?php else: ?>
    <h2 class="b-article_t">
        <a href="<?=$data->getUrl() ?>" class="b-article_t-a"><?=$data->title ?></a>
    </h2>

    <div class="b-article_in clearfix">
        <div class="wysiwyg-content clearfix">
            <p><?=$data->preview ?></p>
            <?php if ($photo):?>
                <div class="b-article_in-img">
                    <img src="<?=$photo->getPreviewUrl(580, 1000, Image::WIDTH) ?>" class="content-img">
                </div>
            <?php endif ?>
        </div>
    </div>

    <div class="textalign-r margin-15">
        <a href="<?=$data->getUrl() ?>" class="b-article_more">Смотреть далее</a>
    </div>
<?php endif ?>