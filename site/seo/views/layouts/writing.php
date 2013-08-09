<?php $this->beginContent('//layouts/main');?>

<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('main-editor'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Конкуренты',
                        'url' => array('/competitors/default/index'),
                        'active'=> Yii::app()->controller->uniqueId == 'competitors/default'
                    ),
                    array(
                        'label' => 'Раздача заданий',
                        'url' => array('/writing/editor/tasks/'),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/writing/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/editor/reports/'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('editor'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Раздача заданий',
                        'url' => array('/writing/editor/tasks/'),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/writing/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/editor/reports/'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('admin'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Раздача заданий',
                        'url' => array('/writing/editor/tasks/'),
                        'template' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span><div class="count"><a href="' . $this->createUrl('/writing/editor/tasks') . '">' . TempKeyword::model()->count('owner_id=' . Yii::app()->user->id) . '</a></div>',
                    ),
                    array(
                        'label' => 'Конкуренты',
                        'url' => array('/competitors/default/index'),
                    ),
                )));


        if (Yii::app()->user->checkAccess('moderator-panel'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/moderator/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/moderator/reports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('author'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/author/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/author/reports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('content-manager'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/content/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/content/reports'),
                    ),
                )));

        ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>

</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>