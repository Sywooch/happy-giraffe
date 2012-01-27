<?php $this->beginContent('//layouts/main'); ?>
<!-- .header -->
<div class="navigation">
    <?php
    $this->widget('zii.widgets.CMenu', array(
        'linkLabelWrapper' => 'span',
        'items'=>array(
            array(
                'label'=>'Главная',
                'url'=>array('modules/index'),
            ),
            array('label'=>'Имена',
                'url'=>array('/club/names/index'),
                'active'=>(Yii::app()->controller->id == 'club/names')
            )
        ),
    ));?>
    <div class="clear"></div>
    <!-- .clear -->
</div>
<!-- .navigation -->
<div class="content">
	<?php echo $content; ?>
</div>
<!-- .content -->
<?php $this->endContent(); ?>