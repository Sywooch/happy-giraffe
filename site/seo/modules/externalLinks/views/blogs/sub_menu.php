<div class="nav clearfix">
    <?php

    $this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array(
                'label' => 'Добавить',
                'url' => array('/externalLinks/blogs/index')
            ),
            array(
                'label' => 'Выполнено',
                'url' => array('/externalLinks/blogs/executed'),
            ),
            array(
                'label' => 'Отчеты',
                'url' => array('/externalLinks/blogs/reports'),
            ),
            array(
                'label' => 'Черный список',
                'url' => array('/externalLinks/blogs/blacklist'),
            ),
            array(
                'label' => 'Белый список',
                'url' => array('/externalLinks/blogs/list'),
            ),
        )));
    ?>
</div>