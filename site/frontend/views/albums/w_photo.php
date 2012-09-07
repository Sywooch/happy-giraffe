<?php
    /* @var AlbumsController $this
     * @var HActiveRecord $model
     * @var AlbumPhoto $photo
     */

    $collection = $model->photoCollection;
    $title = $collection['title'];
    $photos = $collection['photos'];
    $count = count($photos);

    $currentIndex = 0;
    foreach ($photos as $i => $p) {
        if ($p->id == $photo->id) {
            $photo = $p;
            $currentIndex = $i;
            break;
        }
    }

    $preload = array();
    $preload[$currentIndex] = $photos[$currentIndex];
    $currentNext = $currentIndex;
    $currentPrev = $currentIndex;
    for ($i = 0; $i < 3; $i++) {
        $currentNext = ($currentNext == ($count - 1)) ? 0 : ($currentNext + 1);
        $currentPrev = ($currentPrev == 0) ? ($count - 1) : ($currentPrev - 1);
        $preload[$currentNext] = $photos[$currentNext];
        $preload[$currentPrev] = $photos[$currentPrev];
    }

    $more = Album::model()->findAll(array(
        'limit' => 3,
        'order' => new CDbExpression('RAND()'),
        'scopes' => array('noSystem'),
        'condition' => 'id != :current_id',
        'params' => array(':current_id' => $model->id),
        'with' => array(
            'photos' => array(
                'joinType' => 'INNER JOIN',
                'limit' => 1,
                'order' => new CDbExpression('RAND()'),
            ),
        ),
    ));
?>

<div id="photo-window-in">

    <div class="top-line clearfix">

        <a onclick="$.fancybox.close();" href="javascript:void(0);" class="close"></a>

            <div class="user">
                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $photo->author,
                    'size' => 'small',
                    'sendButton' => false,
                    'location' => false
                )); ?>
            </div>

        <div class="photo-container">
            <div class="photo-info">
                <?=$title?> - <span class="count"><span><?=($currentIndex + 1)?></span> фото из <?=$count?></span>
                <div class="title"><?=$photo->w_title?></div>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        <?php ob_start(); ?>
        <?php foreach ($preload as $i => $p): ?>
            pGallery.photos[<?php echo $p->id ?>] = {
                idx : <?=$i + 1?>,
                prev : <?=($i != 0) ? $photos[$i - 1]->id : 'null'?>,
                next : <?=($i < $count - 1) ? $photos[$i + 1]->id : 'null'?>,
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT, true); ?>',
                title : <?=($p->w_title === null) ? 'null' : '\'' . CJavaScript::quote($p->w_title) . '\''?>,
                description : <?=($p->w_description === null) ? 'null' : '\'' . CJavaScript::quote($p->w_description) . '\''?>,
                avatar : '<?php
                        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $p->author,
                            'size' => 'small',
                            'sendButton' => false,
                            'location' => false
                        ));
                ?>'
            };
        <?php endforeach; ?>
        <?php
            $ob = ob_get_clean();
            echo str_replace(array("\n", "\r"), '', $ob);
        ?>
        $.ajax({
            url : '/albums/postLoad/',
            data : {
                entity : '<?=get_class($model)?>',
                entity_id : '<?=($model->id !== null) ? $model->id : 'null'?>'
            },
            dataType : 'script'
        });
        pGallery.first = <?=$photos[0]->id?>;
        pGallery.last = <?=end($photos)->id?>;
    </script>

    <div class="photo-container">
        <div id="photo">

            <div class="img">
                <table><tr><td><?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), '')?></td></tr></table>
            </div>

            <a href="javascript:void(0)" class="prev"><i class="icon"></i>предыдушая</a>
            <a href="javascript:void(0)" class="next"><i class="icon"></i>следующая</a>

        </div>

        <div class="photo-comment">
            <p><?=$photo->w_description?></p>
        </div>


        <div id="w-photo-content">
            <?php $this->renderPartial('w_photo_content', compact('model', 'photo')); ?>
        </div>
    </div>

    <div class="rewatch-container" style="display: none;">

        <div class="album-end">

            <div class="block-title">Вы посмотрели альбом "<?=$title?>"</div>

            <span class="count"><?=$count?> фото</span>

            <a href="javascript:void(0)" class="re-watch"><i class="icon"></i><span>Посмотреть еще раз</span></a>

        </div>

        <div class="more-albums">
            <div class="block-in">
                <div class="block-title"><span>Другие альбомы</span></div>

                <div class="gallery-photos-new clearfix">
                    <ul>

                        <?php foreach ($more as $album): ?>
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
                        <?php endforeach; ?>

                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>