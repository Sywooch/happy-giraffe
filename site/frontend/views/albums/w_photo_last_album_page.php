<?php
/**
 * @var Album[] $more
 * @var int $count
 * @var string $title
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
?><div class="album-end">

    <div class="block-title">Вы посмотрели "<?=$title?>"</div>

    <span class="count"><?=$count?> фото</span>

    <a href="javascript:void(0)" class="re-watch"><i class="icon"></i><span>Посмотреть еще раз</span></a>

</div>

<?php if ($more !== null): ?>
    <div class="more-albums">
        <div class="block-in">
            <div class="block-title"><span>Другие альбомы</span></div>

            <div class="gallery-photos-new clearfix">
                <ul>

                    <?php $i = 0; foreach ($more as $album): ?>
                        <?php if ($album->photos): ?>
                            <?php $i++; ?>
                            <li>
                                <div class="img" data-id="<?=$album->photos[0]->id?>" data-entity="<?=get_class($album)?>" data-entity-id="<?=$album->id?>" data-entity-url="<?=$album->url?>">
                                    <a href="javascript:void(0)">
                                        <?=CHtml::image($album->photos[0]->getPreviewUrl(210, null, Image::WIDTH))?>
                                        <span class="count"><i class="icon"></i> <?=$album->photoCount?> фото</span>
                                        <span class="btn">Посмотреть</span>
                                    </a>
                                </div>
                                <div class="item-title"><?=CHtml::link($album->title, $album->url)?></div>
                            </li>
                            <?php if ($i == 3) break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>

                </ul>
            </div>
        </div>

    </div>
<?php endif; ?>