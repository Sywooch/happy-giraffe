<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css'); ?>
    <div class="left-inner">
        <a href="/"><img src="/images/leftban.png"></a>
    </div>

    <div class="right-inner">
        <?php echo $content; ?>
    </div>
    <div class="clear"></div>
<?php $this->endContent(); ?>