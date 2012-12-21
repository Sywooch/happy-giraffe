<?php $this->beginContent('//layouts/main');?>

<div class="clearfix">
    <div class="default-nav">

        <?php
        if (Yii::app()->user->checkAccess('editor'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'Новые слова',
                        'url' => $this->createUrl('/competitors/default/index', array('section'=>10)),
                        'active'=> Yii::app()->controller->uniqueId == 'competitors/default' && Yii::app()->request->getParam('section') == 10
                    ),
                    array(
                        'label' => 'Рукоделие',
                        'url' => $this->createUrl('/writing/editor/index', array('theme'=>3)),
                        'active'=> Yii::app()->controller->action->id == 'index' && Yii::app()->request->getParam('theme') == 3
                    ),
                    array(
                        'label' => 'Интерьер',
                        'url' => $this->createUrl('/writing/editor/index', array('theme'=>6)),
                        'active'=> Yii::app()->controller->action->id == 'index' && Yii::app()->request->getParam('theme') == 6
                    ),
                    array(
                        'label' => 'Конкуренты',
                        'url' => array('/competitors/default/index'),
                        'active'=> Yii::app()->controller->uniqueId == 'competitors/default' && Yii::app()->request->getParam('section') != 10
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
                        'label' => 'Рукоделие',
                        'url' => $this->createUrl('/writing/editor/index', array('theme'=>5)),
                        'active'=> Yii::app()->controller->action->id == 'index' && Yii::app()->request->getParam('theme') == 5
                    ),
                    array(
                        'label' => 'Интерьер',
                        'url' => $this->createUrl('/writing/editor/index', array('theme'=>6)),
                        'active'=> Yii::app()->controller->action->id == 'index' && Yii::app()->request->getParam('theme') == 6
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

        if (Yii::app()->user->checkAccess('corrector'))
            $this->widget('zii.widgets.CMenu', array(
                'itemTemplate' => '{menu}<span class="tale"><img src="/images/default_nav_active.gif"></span>',
                'items' => array(
                    array(
                        'label' => 'В работу',
                        'url' => array('/writing/corrector/index'),
                    ),
                    array(
                        'label' => 'Отчеты',
                        'url' => array('/writing/corrector/reports'),
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