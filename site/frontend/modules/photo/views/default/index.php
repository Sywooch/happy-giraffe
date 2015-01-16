<?php
/**
 * @var \LiteController $this
 * @var int $userId
 * @var \User $user
 * @var ClientScript $cs
 */
$this->owner = $user;
$this->metaNoindex = true;
$this->pageTitle = $user->getFullName() . ' - Фотоальбомы';
$this->breadcrumbs += array(
    'Фото',
);
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-albums', array('kow'));
?>

<?php $this->widget('site\frontend\modules\userProfile\widgets\UserSectionWidget', array('user' => $this->owner)); ?>

<div class="b-main_cont">
    <photo-albums params="userId: <?= $userId ?>"></photo-albums>
</div>
