<?php $this->beginContent('application.modules.iframe.views._parts.common'); ?>
    <div class="layout-loose">
        <div class="layout-header">
            <?php $this->renderPartial('application.modules.iframe.views._parts.header_lite'); ?>
        </div>
        <div class="layout-wrapper layout-wrapper--theme-mobile clearfix">
            <?=$content?>
        </div>
    </div>
<?php $this->endContent(); ?>