<?php
/**
 * @var $model CActiveRecord
 * @author Alex Kireev <alexk984@gmail.com>
 */

if ($model !== null) {
    $photo = $model->getPhoto();
    ?>
<div class="user-notice-list_post js-powertip-white"
     data-powertip="<?php if (method_exists($model, 'getPowerTipTitle')) echo $model->getPowerTipTitle() ?>">
    <?php if (!empty($photo)): ?>
        <div
            class="user-notice-list_post-img<?php if (method_exists($model, 'isVideo') && $model->isVideo()) echo ' user-notice-list_post-img__video' ?>">
            <img src="<?= $photo->getPreviewUrl(60, 40, false, true) ?>">
        </div>
    <?php endif ?>
    <a href="<?= $model->url ?>" class="user-notice-list_post-a"><?= $model->getContentTitle() ?></a>
    </div><?php } else { ?>
    <div class="user-notice-list_post js-powertip-white"></div><?php
}