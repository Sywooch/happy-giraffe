<?php
    /**
     * Author: choo
     * Date: 20.07.2012
     */
    $collection = $model->getPhotoCollection($photo_id);
    $photos = $collection['photos'];
    $count = count($photos);
?>

<?php ob_start(); ?>
<?php foreach ($photos as $i => $p): ?>
    pGallery.photos[<?php echo $p->id ?>] = {
    idx : <?=$i + 1?>,
    prev : <?=($i != 0) ? $photos[$i - 1]->id : 'null'?>,
    next : <?=($i < $count - 1) ? $photos[$i + 1]->id : 'null'?>,
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