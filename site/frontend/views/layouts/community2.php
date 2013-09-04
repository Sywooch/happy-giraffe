<?php $this->beginContent('//layouts/community'); ?>

    <div class="col-1">
        <?php $this->renderPartial('application.modules.community.views.default._users2'); ?>
    </div>

    <div class="col-23-middle ">

        <?=$content ?>

    </div>

<?php $this->endContent(); ?>