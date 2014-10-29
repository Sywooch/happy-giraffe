<?php
/**
 * @var PhotoController $this
 * @var int $id
 * @var int $userId
 * @var \site\frontend\modules\photo\models\PhotoAlbum $album
 * @var ClientScript $cs
 */
$this->pageTitle = 'Фотоальбом' ;
$this->breadcrumbs['Фото'] = array('/photo/default/index', 'userId' => $userId);
$this->breadcrumbs[] = $album->title;
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-album', array('kow'));
?>
<?php //$this->widget('profile.widgets.UserSectionWidget'); ?>

<photo-album params="userId: <?= $userId ?>, albumId: <?= $id ?>"></photo-album>