<?php
    /* @var AlbumsController $this
     * @var HActiveRecord $model
     * @var AlbumPhoto $photo
     */
    $collection = $model->photoCollection;
    $title = $collection['title'];
    $photos = $collection['photos'];
    $count = count($photos);
?>

<div id="photo-window-in">

    <div class="top-line clearfix">

        <a href="javascript:void(0);" class="close" onclick="closePhoto();"></a>

        <div class="user">
            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                'user' => $photo->author,
                'size' => 'small',
                'sendButton' => false,
                'location' => false
            )); ?>
        </div>

        <div class="photo-info">
            <?=$title?> - <span class="count">3 фото из 158</span>
            <div class="title"><?=$photo->title?></div>
        </div>

    </div>

    <script type="text/javascript">
        <?php ob_start(); ?>
        <?php foreach ($photos as $i => $p): ?>
            pGallery.photos[<?php echo $p->primaryKey ?>] = {
                index : <?=$i + 1?>,
                prev : <?=($i != 0) ? $photos[$i - 1]->primaryKey : 'null'?>,
                next : <?=($i < $count - 1) ? $photos[$i + 1]->primaryKey : 'null'?>,
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT, true); ?>',
                title : <?=($p->title === null) ? 'null' : '\'' . $p->title . '\''?>,
                description : <?=($p->description === null) ? 'null' : '\'' . $p->description . '\''?>,
                avatar : '<?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                    'user' => $p->author,
                    'size' => 'small',
                    'sendButton' => false,
                    'location' => false
                )); ?>'
            };

            <?php if ($i == 0): ?>
               pGallery.first = <?=$p->primaryKey?>;
            <?php endif; ?>

            <?php if ($i < $count - 1): ?>
                pGallery.last = <?=$p->primaryKey?>;
            <?php endif; ?>
        <?php endforeach; ?>
        <?
            $params = ob_get_contents();
            ob_end_clean();
            echo preg_replace('/\s+/i', ' ', $params);
        ?>
    </script>

    <div id="photo">

        <div class="img">
            <table><tr><td><?=CHtml::image($photo->getPreviewUrl(960, 627, Image::HEIGHT, true), '')?></td></tr></table>
        </div>

        <a href="javascript:void(0)" class="prev"><i class="icon"></i>предыдушая</a>
        <a href="javascript:void(0)" class="next"><i class="icon"></i>следующая</a>

    </div>

    <div class="photo-comment">
        <p><?=$photo->description?></p>
    </div>


    <div id="w-photo-content">
        <?php $this->renderPartial('w_photo_content', compact('model', 'photo')); ?>
    </div>

</div>