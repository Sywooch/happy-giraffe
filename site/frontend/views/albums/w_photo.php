<?php
/* @var AlbumsController $this
 * @var HActiveRecord $model
 * @var AlbumPhoto $photo
 */

if (get_class($model) == 'Album') {
    $current = Yii::app()->session->get('viewedAlbums', array());
    $current[$model->id] = $model->id;
    Yii::app()->session['viewedAlbums'] = $current;


    $more = Album::model()->findAll(array(
        'scopes' => array('noSystem'),
        'condition' => 't.author_id = :author_id AND t.id != :current_id',
        'params' => array(':author_id' => $model->author_id, ':current_id' => $model->id),
        'order' => 't.id IN(' . implode(',', Yii::app()->session->get('viewedAlbums', array())) . '), RAND()',
    ));
} else {
    $more = null;
}

if (get_class($model) == 'Contest') {
    $collection = $model->getPhotoCollection($photo->getAttachByEntity('ContestWork')->model->id);
    $title = $collection['title'];
    $photos = $preload = $collection['photos'];
    $count = $collection['count'];
    $currentIndex = $collection['currentIndex'];
    foreach ($photos as $p) {
        if ($p->id == $photo->id)
            $photo = $p;
    }
} elseif (get_class($model) == 'CookDecorationCategory') {
    $collection = $model->getPhotoCollection($photo->id);
    $title = $collection['title'];
    $photos = $preload = $collection['photos'];
    $count = $model->getPhotoCollectionCount();
    $currentIndex = $model->getIndex($photo->id);
} else {
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
}
?>

<script type="text/javascript">
    <?php ob_start(); ?>
    <?php foreach ($preload as $i => $p): ?>
    pGallery.photos[<?php echo $p->id ?>] = {
        idx : <?=(($p->w_idx !== null) ? $p->w_idx : $i) + 1?>,
        prev : <?=($i != 0) ? $photos[$i - 1]->id : 'null'?>,
        next : <?=($i < count($preload) - 1) ? $photos[$i + 1]->id : 'null'?>,
        src : '<?php echo $p->getPreviewUrl(960, 627, Image::HEIGHT); ?>',
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
            entity_id : '<?=($model->id !== null) ? $model->id : 'null'?>',
            sort : '<?=Yii::app()->request->getQuery('sort', 'created')?>',
            photo_id: '<?=$photo->id?>'
        },
        dataType : 'script'
    });
    pGallery.first = <?=$photos[0]->id?>;
    pGallery.last = <?=end($photos)->id?>;
    pGallery.start = <?=$photo->id?>;
</script>

<?php $this->renderPartial(in_array(get_class($model), array('CommunityContentGallery', 'Contest')) && false ? 'w_photo_banner' : 'w_photo_simple', compact('photo', 'title', 'model', 'currentIndex', 'count', 'preload', 'photos', 'more')); ?>