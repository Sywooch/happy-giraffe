<?php
/**
 * @var LiteController $this
 */
$this->beginContent('/layouts/parts/common');
?>

    <?php $this->renderPartial('application.modules.comments.modules.contest.views._banner'); ?>
    <div class="layout-header">
        <header class="header header--bg header--style header-iframe--bg">
    		<?php $this->renderPartial('application.modules.iframe.views.layouts.parts.header'); ?>
        </header>
    </div>

	<main class="b-main b-main-iframe">
        <div class="b-main__inner">
        	<?= $content ?>
        </div>
    </main>
    <?php $this->renderPartial('application.modules.iframe.views.layouts.parts.footer'); ?>
<?php $this->endContent(); ?>