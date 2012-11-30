<div class="broadcast-title-box">
    <h1><i class="icon-boradcast"></i> Что нового</h1>

    <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Прямой эфир',
                    'url' => array('/whatsNew/index'),
                ),
                array(
                    'label' => 'В клубах',
                    'url' => array('whatsNew/clubs'),
                    'submenuOptions' => array(
                        'class' => 'broadcast-menu_drop',
                    ),
                    'items' => array(
                        array(
                            'label' => 'В моих',
                            'url' => array('whatsNew/clubs', 'show' => 'my'),
                        ),
                        array(
                            'label' => 'Во всех',
                            'url' => array('whatsNew/clubs', 'show' => 'all'),
                        ),
                    )
                ),
                array(
                    'label' => 'В блогах',
                    'url' => array('whatsNew/blogs'),
                    'submenuOptions' => array(
                        'class' => 'broadcast-menu_drop',
                    ),
                    'items' => array(
                        array(
                            'label' => 'Подписка',
                            'url' => array('whatsNew/blogs', 'show' => 'my'),
                        ),
                        array(
                            'label' => 'Все',
                            'url' => array('whatsNew/blogs', 'show' => 'all'),
                        ),
                    )
                ),
            ),
            'htmlOptions' => array(
                'class' => 'broadcast-menu',
            ),
        ));
    ?>
</div>