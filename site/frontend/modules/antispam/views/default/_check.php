<?php
/**
 * @var HController $this
 * @var AntispamCheck $data
 */
?>

<!-- antispam_i-->
<div class="antispam_i clearfix">
    <div class="antispam_cont">
        <?php if ($data->entity == 'CommunityContent' || $data->entity == 'BlogContent'): ?>
            <?php $this->renderPartial('site.frontend.modules.blog.views.default.view', array('data' => $data->relatedModel, 'full' => false)); ?>
        <?php endif; ?>
        <?php if ($data->entity == 'Comment'): ?>
            <?php $this->renderPartial('_content/comment', array('data' => $data->relatedModel)); ?>
        <?php endif; ?>
        <?php if ($data->entity == 'AlbumPhoto'): ?>
            <?php $this->renderPartial('_content/photo', array('data' => $data->relatedModel)); ?>
        <?php endif; ?>
    </div>
    <?php $this->widget('MarkWidget', array('check' => $data)); ?>
</div>
<!-- /antispam_i-->