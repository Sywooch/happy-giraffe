<?php
/**
 * @var \site\frontend\modules\photo\components\PhotoController $this
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

<?php if (! $this->isPersonalArea()): ?><div class="b-main_cont"><?php endif; ?>
    <photo-albums params="userId: <?= $userId ?>"></photo-albums>
<?php if (! $this->isPersonalArea()): ?></div><?php endif; ?>
