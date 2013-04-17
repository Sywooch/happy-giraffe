<?php $this->beginContent('//layouts/new');?>

    <nav class="header-nav">
        <?php $this->widget('zii.widgets.CMenu', array(
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'header-nav_ul'),
            'items' => array(
                array(
                    'label' => '<span class="header-nav_tx">Задания</span>',
                    'url' => array('/commentators/default/index'),
                    'linkOptions' => array('class' => 'header-nav_i'),
                    'itemOptions' => array('class' => 'header-nav_li header-nav_li__tasks'),
                    'active' => (Yii::app()->controller->action->id == 'index')
                ),
                array(
                    'label' => '<span class="header-nav_tx">Ссылки</span>',
                    'url' => array('/commentators/default/links'),
                    'linkOptions' => array('class' => 'header-nav_i'),
                    'itemOptions' => array('class' => 'header-nav_li header-nav_li__links'),
                    'active' => (Yii::app()->controller->action->id == 'links')
                ),
                array(
                    'label' => '<span class="header-nav_tx">Отчеты</span>',
                    'url' => array('/commentators/default/reports'),
                    'linkOptions' => array('class' => 'header-nav_i'),
                    'itemOptions' => array('class' => 'header-nav_li header-nav_li__reports'),
                    'active' => (Yii::app()->controller->action->id == 'reports')
                ),
                array(
                    'label' => '<span class="header-nav_tx">Премия</span>',
                    'url' => array('/commentators/default/award'),
                    'linkOptions' => array('class' => 'header-nav_i'),
                    'itemOptions' => array('class' => 'header-nav_li header-nav_li__award'),
                    'active' => (Yii::app()->controller->action->id == 'award')
                ),
            ),
        ));

        ?>
    </nav>
    </div>

    <?= $content ?>

<?php $this->endContent(); ?>