<?php $this->beginContent('//layouts/new/common'); ?>
<?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
<?php $this->renderPartial('//_header'); ?>
<div class="layout-wrapper">
    <?=$content?>
</div>
<?php $this->endContent(); ?>