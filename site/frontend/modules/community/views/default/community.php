<?php
/**
 * @var User[] $moderators модераторы клуба
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var int $rubric_id выбранная рубрика
 */

?>
<div class="col-1">
    <?php $this->renderPartial('_users'); ?>
    <?php $this->renderPartial('_rubrics'); ?>
</div>
<div class="col-23-middle ">
    <?php $this->renderPartial('_list'); ?>
</div>
