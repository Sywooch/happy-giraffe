<div class="gallery-box">
    <a class="img" data-id="<?=$data->gallery->items[0]->photo->id?>">
        <?php echo CHtml::image($data->gallery->items[0]->photo->getPreviewUrl(695, 463, Image::WIDTH)) ?>

        <div class="title">
            <?=CHtml::encode($data->gallery->title)?>
        </div>
        <div class="count">
            смотреть <span><?=count($data->gallery->items)?> ФОТО</span>
        </div>
        <i class="icon-play"></i>
    </a>
</div>