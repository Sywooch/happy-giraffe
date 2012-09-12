<div class="ext-links-add">

    <div class="nav clearfix">
        <?php

        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Добавить',
                    'url' => array('/externalLinks/sites/index')
                ),
                array(
                    'label' => 'Отчеты',
                    'url' => array('/externalLinks/sites/reports'),
                ),
            )));
        ?>
    </div>

</div>