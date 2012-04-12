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
    <?php if (!Yii::app()->user->isGuest && Yii::app()->user->checkAccess('editMorning')):?>
    <div class="club-fast-add clearfix">
        <a class="btn btn-green" href="<?=$this->createUrl('/morning/edit') ?>"><span><span>Добавить</span></span></a>
    </div>
    <div class="club-fast-add clearfix">
        <a class="btn btn-green" href="<?=$this->createUrl('/morning/publicAll') ?>"><span><span>Опублликовать все</span></span></a>
    </div>
    <?php endif ?>

    <div class="main-right morning-main">

        <?=$content ?>

    </div>

    <?php if ($this->time !== null) $this->renderPartial('_sidebar'); ?>

</div>

<?php $this->endContent(); ?>