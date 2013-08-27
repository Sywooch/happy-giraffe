<?php
/**
 * @var User[] $moderators модераторы клуба
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var int $rubric_id выбранная рубрика
 */

?>
<div class="b-section b-section__club b-section__green">
    <div class="b-section_hold">
        <div class="content-cols clearfix">

            <?php $this->renderPartial('_main_image', array('size' => 240)); ?>

            <div class="col-23-middle clearfix js-community-subscription">

                <?php $this->renderPartial('_moderators', compact('moderators')); ?>
                <?php $this->renderPartial('_links', array('root' => true)); ?>

            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->renderPartial('_users', compact('users', 'user_count')); ?>

        <?php $this->renderPartial('_rubrics', compact('rubric_id')); ?>

    </div>
    <div class="col-23-middle ">
        <?php $this->renderPartial('_list', compact('rubric_id')); ?>
    </div>
</div>