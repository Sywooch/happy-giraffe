<?php
/**
 * @var CommunityClub $club
 */
?>

<?php if (Yii::app()->user->isGuest): ?>
    <a class="btn green-btn btn-xl btn-question login-button" data-bind="follow: {}">Добавить тему</a>
<?php else: ?>
    <a class="btn green-btn btn-xl btn-question fancy-top is-need-loading" href="<?=$this->createUrl('/posts/forums/posts/AddForm', [
        'club_id' => $club->id
    ])?>">Добавить тему</a>
<?php endif; ?>