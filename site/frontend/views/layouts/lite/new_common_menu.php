<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/new_common');
?>

    <?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
    <div class="layout-header">
        <header class="header header--bg header--style">
    		<?php $this->renderPartial('//_new_header'); ?>
        </header>
    </div>

	<main class="b-main">
        <?= $content ?>
    </main>
    <?php $this->renderPartial('//_new_footer'); ?>
<?php $this->endContent(); ?>