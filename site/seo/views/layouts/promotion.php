<?php $this->beginContent('//layouts/main');?>

<div class="clearfix">
    <div class="default-nav">

        <?php
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Позиции',
                        'url' => array('/promotion/queries/admin'),
                    ),
                    array(
                        'label' => 'Перелинковка',
                        'active'=> (Yii::app()->controller->id == 'linking' && Yii::app()->controller->action->id != 'autoLinking'),
                        'url' => 'javascript:;',
                    ),
                    array(
                        'label' => 'Автомат',
                        'url' => array('/promotion/linking/autoLinking'),
                    ),
                    array(
                        'label' => 'Проверка ссылок',
                        'url' => array('/promotion/linking/сheckLinks'),
                    ),
                    array(
                        'label' => 'SAPE',
                        'url' => 'javascript:;',
                    ),
                )));

        ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>

</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>