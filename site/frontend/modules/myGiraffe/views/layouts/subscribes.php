<?php
Yii::app()->clientScript->registerPackage('ko_blog');

$this->beginContent('//layouts/main'); ?>
<div class="content-cols">
    <div class="col-1">
        <?php $this->widget('Avatar', array('user' => Yii::app()->user->getModel(), 'size' => 200)); ?>

        <div class="menu-list">
            <a href="<?=$this->createUrl('/myGiraffe/default/recommends') ?>" class="menu-list_i menu-list_i__all<?php if (Yii::app()->controller->action->id == 'recommends') echo ' active' ?>">
                <span class="menu-list_tx">Рекомедации подписок</span>
            </a>
            <a href="<?=$this->createUrl('/myGiraffe/default/subscribes') ?>" class="menu-list_i menu-list_i__photo<?php if (Yii::app()->controller->action->id == 'subscribes') echo ' active' ?>">
                <span class="menu-list_tx">Мои подписки</span>
            </a>
        </div>
    </div>

    <div class="col-23-middle clearfix">

        <?=$content ?>

    </div>
</div>
<?php $this->endContent(); ?>