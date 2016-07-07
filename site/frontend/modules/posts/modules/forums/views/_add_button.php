<?php
/**
 * @var CommunityClub $club
 */
?>

<?php if (Yii::app()->user->isGuest): ?>
    <a class="btn btn-success btn-xl btn-question w-240 login-button" data-bind="follow: {}">Добавить тему</a>
<?php else: ?>
    <a class="btn btn-success btn-xl btn-question w-240 fancy-top" href="<?=$this->createUrl('/blog/default/form', [
        'type' => CommunityContent::TYPE_POST,
        'club_id' => $club->id,
        'useAMD' => true,
        'short' => true,
    ])?>">Добавить тему</a>
<?php endif; ?>