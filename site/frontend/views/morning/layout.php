<?php $this->beginContent('//layouts/main'); ?>

<div id="morning" class="clearfix">

    <div class="main-right morning-main">

        <?=$content ?>

    </div>

    <?php if ($this->time !== null) $this->renderPartial('_sidebar'); ?>

</div>

<?php $this->endContent(); ?>