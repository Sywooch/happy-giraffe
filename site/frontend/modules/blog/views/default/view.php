<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */
?>
<div class="b-article clearfix<?php if ($data->type_id == CommunityContentType::TYPE_STATUS) echo ' b-article__user-status' ?>">
    <div class="float-l">
        <?php $this->renderPartial('_post_controls', array('model' => $data)); ?>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>

        <?php $this->renderPartial('_post_header', array('model' => $data)); ?>

        <?php $this->renderPartial('types/type_' . $data->type_id, compact('data', 'full')); ?>

        <?php if ($full) $this->renderPartial('_likes',compact('data')); ?>

        <?php if ($full) $this->renderPartial('_prev_next', compact('data')); ?>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => $full)); ?>

    </div>
</div>