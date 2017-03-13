<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>

<?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
    <div class="layout-header">
        <div class="layout-loose_hold clearfix">
            <!-- b-main -->
            <div class="b-main clearfix">
                <?= $content ?>
            </div>
            <!-- b-main -->
        </div>
    </div>
<?php $this->endContent(); ?>