<?php
/**
 * @var PhotoController $this
 * @var int $userId
 * @var \User $user
 * @var ClientScript $cs
 */
$cs = Yii::app()->clientScript;
$cs->registerAMD('photo-albums', array('kow'));
?>
<?php $this->widget('profile.widgets.UserSectionWidget', compact('user')); ?>

<photo-albums params="userId: <?= $userId ?>"></photo-albums>
