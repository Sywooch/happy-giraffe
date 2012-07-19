<?php
    /* @var AlbumsController $this
     * @var HActiveRecord $model
     * @var AlbumPhoto $photo
     */

    $collection = $model->photoCollection;
    $title = $collection['title'];
    $photos = $collection['photos'];
    $count = count($photos);

    foreach ($photos as $i => $p) {
        if ($p->id == $photo->id) {
            $photo = $p;
            $currentIndex = $i + 1;
            break;
        }
    }
?>

<div id="photo-window-in">

    <div class="top-line clearfix">

        <a href="javascript:void(0)" class="close"></a>

        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $photo->author,
                'size' => 'small',
                'sendButton' => false,
                'location' => false
            )); ?>
        </div>

        <div class="photo-info">
            <?=$title?> - <span class="count"><span><?=$currentIndex?></span> фото из <?=$count?></span>
            <div class="title"><?=$photo->w_title?></div>
        </div>

    </div>

    <script type="text/javascript">
        <?php ob_start(); ?>
        <?php foreach ($photos as $i => $p): ?>
            pGallery.photos[<?php echo $p->id ?>] = {
                idx : <?=$i + 1?>,
                prev : <?=($i != 0) ? $photos[$i - 1]->id : 'null'?>,
                next : <?=($i < $count - 1) ? $photos[$i + 1]->id : 'null'?>,
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT, true); ?>',
                title : <?=($p->w_title === null) ? 'null' : '\'' . $p->w_title . '\''?>,
                description : <?=($p->w_description === null) ? 'null' : '\'' . $p->w_description . '\''?>,
                avatar : <?php
                    if (($i == 0 && $photo->author_id == $p->author_id) || ($i != 0 && $p->author_id == $photos[$i - 1]->author_id)) {
                        echo 'null';
                    } else {
                        echo '\'';
                        $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                            'user' => $p->author,
                            'size' => 'small',
                            'sendButton' => false,
                            'location' => false
                        ));
                        echo '\'';
                    }
                ?>
            };
        <?php endforeach; ?>
        <?php
            $ob = ob_get_clean();
            echo str_replace(array("\n", "\r"), '', $ob);
        ?>
        pGallery.first = <?=$photos[0]->id?>;
        pGallery.last = <?=end($photos)->id?>;
    </script>

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