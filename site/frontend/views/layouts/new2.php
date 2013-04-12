<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=349'); ?>
    <div class="left-inner">
        <?php $this->renderPartial('/banners/community_24_240x400'); ?>
    </div>

    <div class="right-inner">
        <?php echo $content; ?>
    </div>
    <div class="clear"></div>
<?php $this->endContent(); ?>