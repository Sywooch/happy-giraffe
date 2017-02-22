<?php $this->beginContent('//layouts/new/common'); ?>
    <div class="layout-loose">
        <div class="layout-header">
            <?php $this->renderPartial('//_header_lite'); ?>
        </div>
    </div>

    <div class="layout-wrapper layout-wrapper--theme-mobile clearfix">
        <?=$content?>
    </div>
<?php $this->endContent(); ?>