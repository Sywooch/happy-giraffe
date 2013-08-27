<?php
/**
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var int $rubric_id выбранная рубрика
 */
?>
<div class="b-section">
    <div class="b-section_hold">
        <div class="content-cols clearfix">
            <?php $this->renderPartial('_main_image', array('size' => 130)); ?>
            <div class="col-23-middle">
                <div class="padding-l20">
                    <h1 class="b-section_t"><a href=""><?=$this->community->title ?></a></h1>
                    <?php $this->renderPartial('_links', array('forum' => true)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-cols clearfix">
    <div class="col-1">

        <?php $this->renderPartial('_users2', compact('users', 'user_count')); ?>

        <?php $this->renderPartial('_rubrics', compact('rubric_id')); ?>

    </div>
    <div class="col-23-middle ">
        <?php $this->renderPartial('_list', compact('rubric_id')); ?>
    </div>
</div>