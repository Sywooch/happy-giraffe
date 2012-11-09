<div class="nav clearfix">
    <?php

    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array(
                'label' => 'Добавить',
                'url' => array('/externalLinks/forums/index')
            ),
            array(
                'label' => 'Задания',
                'url' => array('/externalLinks/tasks/index/'),
            ),
            array(
                'label' => 'Выполнено',
                'url' => array('/externalLinks/forums/executed'),
            ),
            array(
                'label' => 'Отчеты',
                'url' => array('/externalLinks/forums/reports'),
            ),
            array(
                'label' => 'Черный список',
                'url' => array('/externalLinks/forums/blacklist'),
            ),
        )));
    ?>
</div>