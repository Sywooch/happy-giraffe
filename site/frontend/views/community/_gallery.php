<?php
/**
 * @var $data CommunityContent
 */

//только для новых галерей - скрываем их код
$is_new_gallery = ($data->gallery->id > 1404);
?><?php if ($is_new_gallery) Yii::app()->controller->beginWidget('SeoContentWidget'); ?>
<div class="gallery-box">
    <a class="img" data-id="<?=$data->gallery->items[0]->photo->id?>">
        <?php echo CHtml::image($data->gallery->items[0]->photo->getPreviewUrl(695, 463, Image::WIDTH)) ?>

        <span class="title">
            <?=CHtml::encode($data->gallery->title)?>
        </span>
        <span class="count">
            смотреть <span><?=count($data->gallery->items)?> ФОТО</span>
        </span>
        <i class="icon-play"></i>
    </a>
</div>
<?php if ($is_new_gallery) Yii::app()->controller->endWidget(); ?>