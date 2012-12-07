<div class="broadcast-title-box">
    <h1><i class="icon-boradcast"></i> Что нового</h1>

    <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array(
                    'label' => 'Прямой эфир',
                    'url' => array('/whatsNew/default/index'),
                ),
                array(
                    'label' => 'В клубах',
                    'url' => array('/whatsNew/default/clubs'),
                    'submenuOptions' => array(
                        'class' => 'broadcast-menu_drop',
                    ),
                    'items' => array(
                        array(
                            'label' => 'В моих',
                            'url' => array('/whatsNew/default/clubs', 'show' => 'my'),
                        ),
                        array(
                            'label' => 'Во всех',
                            'url' => array('/whatsNew/default/clubs', 'show' => 'all'),
                        ),
                    )
                ),
                array(
                    'label' => 'В блогах',
                    'url' => array('/whatsNew/default/blogs'),
                    'submenuOptions' => array(
                        'class' => 'broadcast-menu_drop',
                    ),
                    'items' => array(
                        array(
                            'label' => 'Подписка',
                            'url' => array('/whatsNew/default/blogs', 'show' => 'my'),
                        ),
                        array(
                            'label' => 'Все',
                            'url' => array('/whatsNew/default/blogs', 'show' => 'all'),
                        ),
                    )
                ),
                array(
                    'label' => 'У друзей',
                    'url' => array('/whatsNew/friends/index'),
                    'visible' => false,
                ),
            ),
            'htmlOptions' => array(
                'class' => 'broadcast-menu',
            ),
        ));
    ?>
</div>