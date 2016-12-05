<?php $this->beginContent('//layouts/new/common'); ?>
    <div class="layout-loose">
        <div class="layout-header">
            <header class="header header__redesign">
                <?php $this->renderPartial('//_header'); ?>
            </header>
        </div>
    </div>

<div class="layout-wrapper layout-wrapper--theme-mobile clearfix">
    <?=$content?>
</div>
<?php $this->endContent(); ?>