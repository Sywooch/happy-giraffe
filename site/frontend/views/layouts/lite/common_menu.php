<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>
    <?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
    <?php if (Yii::app()->user->isGuest): ?>
        <?php $this->renderPartial('//_header_guest'); ?>
    <?php  else: ?>
        <?php $this->renderDynamic(array($this, 'renderPartial'), '//_menu', null, true); ?>
    <?php endif; ?>
    <div class="layout-loose_hold clearfix">
        <!-- b-main -->
        <div class="b-main clearfix">
            <?= $content ?>
        </div>
        <!-- b-main -->

        <?php $this->renderPartial('//_footer'); ?>
    </div>
<?php $this->endContent(); ?>