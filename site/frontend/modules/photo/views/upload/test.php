<?php
/** @var ClientScript $cs */
$cs = Yii::app()->clientScript;
$cs->registerPackage('ko_photo');
?>

<script>
    $(function() {
        var a = <?=$a?>;
        album = new PhotoAlbum(a.albums);
    });
</script>