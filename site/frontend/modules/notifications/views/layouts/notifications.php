<?php $this->beginContent('//layouts/common_new'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/user.css'); ?>
    <div class="content-cols clearfix">

        <div class="col-1">
            <?php $this->widget('UserAvatarWidget', array('user' => Yii::app()->user->getModel(), 'size' => 200)); ?>
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