<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=349'); ?>
    <div class="left-inner">
        <a href="/contest/1/"><img src="/images/banner_03.png"></a>
    </div>

    <div class="right-inner">
        <?php echo $content; ?>
    </div>
    <div class="clear"></div>
<?php $this->endContent(); ?>