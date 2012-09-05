<?php $this->beginContent('//layouts/main');?>

<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('cook-manager'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => '1. Конкуренты',
                        'url' => array('/cook/cook/index'),
                    ),
                    array(
                        'label' => '2. Рецепты',
                        'url' => array('/cook/cook/recipes'),
                    ),
                    array(
                        'label' => 'Раздача заданий',
                        'url' => array('/cook/cook/tasks/'),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/cook/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/cook/cook/reports/'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('cook-author'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/cook/task/author'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/cook/task/authorReports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('cook-content-manager'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/cook/task/contentManager'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/cook/task/contentManagerReports'),
                    ),
                )));

        ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>

</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>