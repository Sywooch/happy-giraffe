<?php
/**
 * @var $this site\frontend\modules\iframe\controllers\DefaultController
 * @var string $content
 */

$this->beginContent('application.modules.iframe.views._parts.main');
?>
<style>
    .b-main-iframe{
        padding-top: 0;
    }
    .b-main-iframe .b-main__inner{
        padding: 0;
    }
    .userSection-iframe {
        margin: 0;
    }
    .userSection_left{

    }
</style>
<div class="b-col__container">
    <?=$content?>
</div>
<?php $this->endContent(); ?>