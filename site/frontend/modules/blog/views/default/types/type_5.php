<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */

$status = $data->getStatus();
$text = strip_tags($data->status->status->text);
?>
<div class="b-article_in clearfix">
    <div class="b-article_user-status clearfix">
        <?php if (!$full):?>
            <a href="<?=$data->getUrl() ?>" class="b-article_user-status-a"><?=$text ?></a>
        <?php else: ?>
            <?=$text ?>
        <?php endif ?>
    </div>
</div>
