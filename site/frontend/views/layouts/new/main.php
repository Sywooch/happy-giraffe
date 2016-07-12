<?php $this->beginContent('//layouts/new/common'); ?>
    <div class="layout-header header clearfix">
        <header class="header__redesign header_style2">
            <?php $this->renderPartial('//_header'); ?>
        </header>
    </div>
<div class="layout-wrapper">
    <?=$content?>
</div>
<?php $this->endContent(); ?>