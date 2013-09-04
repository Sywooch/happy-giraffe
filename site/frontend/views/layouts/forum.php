<?php $this->beginContent('//layouts/community'); ?>

    <div class="col-1">
        <?php $this->renderPartial('_users2'); ?>
        <?php $this->renderPartial('_rubrics', array('rubrics'=>$this->forum->rubrics)); ?>
    </div>

    <div class="col-23-middle ">

        <?php if (!Yii::app()->user->isGuest):?>
            <div class="clearfix margin-r20 margin-b20 js-community-subscription" data-bind="visible: active">
                <a href="<?= $this->createUrl('/blog/default/form', array('type' => 1, 'club_id' => $this->forum->id)) ?>"
                   class="btn-blue btn-h46 float-r fancy">Добавить в клуб</a>
            </div>
        <?php endif ?>

        <div class="col-gray">
            <?=$content ?>
        </div>

    </div>

<?php $this->endContent(); ?>