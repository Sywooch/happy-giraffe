<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>

    <?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
    <div class="layout-header">

        <header class="header header__redesign">
            <?php $this->renderPartial('//_header'); ?>
        </header>
    </div>

    <div class="layout-loose_hold clearfix">
        <!-- b-main -->
        <div class="b-main clearfix">
            <?= $content ?>
        </div>
        <!-- b-main -->

        <?php $this->renderPartial('//_footer'); ?>
    </div>
<?php $this->endContent(); ?>