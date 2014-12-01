<?php
/**
 * @var \LiteController $this
 * @var int $id
 * @var int $userId
 * @var \site\frontend\modules\photo\models\PhotoAlbum $album
 * @var ClientScript $cs
 */
$this->owner = $album->author;
$this->metaNoindex = true;
$this->pageTitle = 'Фотоальбом' ;
$this->breadcrumbs += array(
    'Фото' => array('/photo/default/index', 'userId' => $userId),
    $album->title,
);
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-album', array('kow'));
?>

<?php $this->widget('profile.widgets.UserSectionWidget', array('user' => $this->owner)); ?>

<div class="b-main_cont">
    <photo-album params="userId: <?= $userId ?>, albumId: <?= $id ?>"></photo-album>
</div>