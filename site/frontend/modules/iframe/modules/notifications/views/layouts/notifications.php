<?php $this->beginContent('//layouts/main'); ?>
    <div class="content-cols clearfix">

        <div class="col-1">
            <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 200)); ?>
        </div>

        <div class="col-23-middle">
            <div class="heading-title clearfix">
                Мои уведомления
            </div>
            <div class="col-gray">
                <?=$content ?>
            </div>
        </div>
    </div>

<?php $this->endContent(); ?>