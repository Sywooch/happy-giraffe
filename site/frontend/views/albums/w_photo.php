<?php
    /* @var AlbumsController $this
     * @var HActiveRecord $model
     * @var AlbumPhoto $photo
     */
    $collection = $model->photoCollection;
    $count = count($model->photoCollection);
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
            Альбом  «Оформление вторые блюда» - <span class="count">3 фото из 158</span>
            <div class="title">Жареный картофель с беконом</div>
        </div>

    </div>

    <script type="text/javascript">
        <?php ob_start(); ?>
        <?php foreach ($collection as $i => $p): ?>
            pGallery.photos[<?php echo $p->primaryKey ?>] = {
                prev : <?=($i != 0) ? $collection[$i - 1]->primaryKey : 'null'?>,
                next : <?=($i < $count - 1) ? $collection[$i + 1]->primaryKey : 'null'?>,
                src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT, true); ?>',
                title : '<?php echo isset($p->title) && $p->title != '' ? $p->title : null ?>',
                description : <?php echo isset($p->options['description']) ? "'" . $p->options['description'] . "'" : 'null'; ?>,
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
        <p>Квашеная капуста с клюквой, грибами, соусом, зеленью и еще очень длинный комментарий про это оформление блюда, да нужно двести знаков для этого комментария, уже вроде набралось или нет кто будет считать</p>
    </div>


    <div id="photo-content">
        <?php $this->renderPartial('w_photo_content', compact('model', 'photo')); ?>
    </div>

</div>