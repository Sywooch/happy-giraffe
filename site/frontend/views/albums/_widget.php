<?php
/**
 * @var AlbumPhoto $model
 */
if ($model->width >= 580):?>
    <div class="b-article_in-img"><img src="<?=$model->getPreviewUrl(580, 1000) ?>" class="content-img"></div>
<?php else: ?>
    <div class="clearfix"><img src="<?=$model->getPreviewUrl(540, 1000) ?>" class="content-img"></div>
<?php endif;