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
                        'label' => 'Автомат',
                        'url' => array('/promotion/linking/autoLinking'),
                    ),
                    array(
                        'label' => 'Проверка ссылок',
                        'url' => array('/promotion/linking/checkLinks'),
                        //'visible'=>Yii::app()->user->checkAccess('')
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