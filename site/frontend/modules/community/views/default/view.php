<?php
/**
 * @var User[] $users подписчики
 * @var int $user_count кол-во подписчиков
 * @var CommunityContent $content кол-во подписчиков
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

        <?php $this->renderPartial('_rubrics', array('rubric_id' => $content->rubric_id)); ?>

    </div>
    <div class="col-23-middle ">
        <div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
            <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1)) ?>" data-theme="transparent"
               class="btn-blue btn-h46 float-r fancy">Добавить в клуб</a>
        </div>
        <div class="col-gray">

            <?php $this->renderPartial('blog.views.default.view', array('full' => true, 'data' => $content)); ?>

        </div>
    </div>
</div>