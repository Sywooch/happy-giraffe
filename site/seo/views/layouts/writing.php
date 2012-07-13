<?php $this->beginContent('//layouts/main');?>

<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('editor'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Конкуренты',
                        'url' => array('/competitors/default/index'),
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

        if (Yii::app()->user->checkAccess('superuser'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Конкуренты',
                        'url' => array('/competitors/default/index'),
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

        if (Yii::app()->user->checkAccess('admin'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Ключевые слова или фразы',
                        'url' => array('/writing/editor/index/'),
                    ),
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


        if (Yii::app()->user->checkAccess('moderator'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/task/moderator'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/task/moderatorReports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('author'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/task/author'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/task/authorReports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('corrector'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/task/corrector'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/task/correctorReports'),
                    ),
                )));

        if (Yii::app()->user->checkAccess('content-manager'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/task/contentManager'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/task/contentManagerReports'),
                    ),
                )));

        ?>
    </div>

    <?php $this->renderPartial('//layouts/_header'); ?>

</div>
<?php echo $content; ?>

<?php $this->endContent(); ?>