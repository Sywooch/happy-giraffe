<?php
/**
 * @var PhotoController $this
 * @var int $id
 * @var int $userId
 * @var \site\frontend\modules\photo\models\PhotoAlbum $album
 * @var ClientScript $cs
 */
$this->pageTitle = 'Фотоальбом' ;
$this->breadcrumbs += array(
    'Фото' => array('/photo/default/index', 'userId' => $userId),
    $album->title,
);
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-album', array('kow'));
?>
<?php //$this->widget('profile.widgets.UserSectionWidget'); ?>

<?php if (! $this->isPersonalArea()): ?><div class="b-main_cont"><?php endif; ?>
    <photo-album params="userId: <?= $userId ?>, albumId: <?= $id ?>"></photo-album>
<?php if (! $this->isPersonalArea()): ?></div><?php endif; ?>