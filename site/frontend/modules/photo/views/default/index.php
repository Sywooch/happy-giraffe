<?php
/**
 * @var PhotoController $this
 * @var int $userId
 * @var \User $user
 * @var ClientScript $cs
 */
$this->pageTitle = $user->getFullName() . ' - Фотоальбомы';
$this->breadcrumbs += array(
    'Фото',
);
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-albums', array('kow'));
?>
<?php $this->widget('profile.widgets.UserSectionWidget'); ?>

<div class="b-main_cont">
    <photo-albums params="userId: <?= $userId ?>"></photo-albums>
</div>
