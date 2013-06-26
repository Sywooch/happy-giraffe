<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 * @var $full bool
 */
//if (!empty($data->real_time))
//$data->created = $data->real_time;
?>
<div class="b-article clearfix<?php if ($data->type_id == CommunityContentType::TYPE_STATUS) echo ' b-article__user-status' ?>">
    <?php if ($data->source_id) $this->renderPartial('_repost', array('data' => $data)); ?>
    <div class="float-l">
        <?php $this->renderPartial('_post_controls', array('model' => $data->getSourceContent())); ?>
    </div>
    <div class="b-article_cont clearfix">
        <div class="b-article_cont-tale"></div>

        <?php $this->renderPartial('_post_header', array('model' => $data->getSourceContent())); ?>

        <?php $this->renderPartial('types/type_' . $data->type_id, array('data' => $data->getSourceContent(), 'full' => $full)); ?>

        <?php if ($full) $this->renderPartial('_likes', array('data' => $data->getSourceContent())); ?>

        <?php if ($full && $data->type_id != CommunityContentType::TYPE_STATUS) $this->renderPartial('_prev_next', compact('data')); ?>

        <?php $this->widget('application.widgets.newCommentWidget.NewCommentWidget', array('model' => $data, 'full' => $full)); ?>

    </div>
</div>