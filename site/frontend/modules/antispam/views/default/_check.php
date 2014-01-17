<?php
/**
 * @var AntispamCheck $data
 */
?>

<!-- antispam_i-->
<div class="antispam_i clearfix">
    <div class="antispam_cont">
        <?php if ($data->entity == 'CommunityContent' || $data->entity == 'BlogContent'): ?>
            <?php $this->renderPartial('site.frontend.modules.blog.views.default.view', array('data' => $data->relatedModel, 'full' => false)); ?>
        <?php endif; ?>
    </div>
    <?php $this->widget('MarkWidget', array('check' => $data)); ?>
</div>
<!-- /antispam_i-->