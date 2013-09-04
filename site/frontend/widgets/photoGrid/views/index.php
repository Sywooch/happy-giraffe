<?php
/**
 * @var AlbumPhoto[] $collection
 */
?>

<style>
    .grid {
        width: 580px;
        border: 1px solid #000;
    }

    .photo {
        float: left;
        margin-right: 4px;
    }

    .photo:last-child {
        margin-right: 0;
    }
</style>

<?php foreach ($collection['photos'] as $p): ?>
    <p><?=$p->width?>x<?=$p->height?></p>
<?php endforeach; ?>

<div class="grid clearfix">
    <?php foreach ($grid as $row): ?>
        <div class="row" style="height: <?=$row['height']?>">
            <?php foreach ($row['photos'] as $p): ?>
                <div class="photo">
                    <?=CHtml::image($p->getPreviewUrl(null, $row['height'], Image::HEIGHT))?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>