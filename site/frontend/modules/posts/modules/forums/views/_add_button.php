<?php
/**
 * @var CommunityClub $club
 */
?>

<?php if (Yii::app()->user->isGuest): ?>
    <a class="btn green-btn btn-xl btn-question login-button" data-bind="follow: {}">Добавить тему</a>
<?php else: ?>
    <a class="btn green-btn btn-xl btn-question fancy-top is-need-loading" href="<?=$this->createUrl('/blog/default/form', [
        'type' => CommunityContent::TYPE_POST,
        'club_id' => $club->id,
        'useAMD' => true,
        'short' => true,
    ])?>">Добавить тему</a>
<?php endif; ?>