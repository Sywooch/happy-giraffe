<?php
    /**
     * Author: choo
     * Date: 20.07.2012
     */
    $collection = $model->photoCollection;
    $photos = $collection['photos'];
?>

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