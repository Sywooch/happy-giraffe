<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('zii.widgets.CBreadcrumbs', array(
    'links' => $this->breadcrumbs,
    'separator' => ' &gt; ',
    'htmlOptions' => array(
        'id' => 'crumbs',
        'class' => null,
    ),
)); ?>
<div id="morning" class="clearfix">

    <div class="main-right morning-main">

        <?=$content ?>

    </div>

    <?php if ($this->time !== null) $this->renderPartial('_sidebar'); ?>

</div>

<?php $this->endContent(); ?>