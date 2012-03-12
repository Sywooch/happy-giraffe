<div class="user-cols clearfix">

    <div class="col-1">

        <div class="side-filter">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => '<span>Все</span>' . $this->user->getFriendsCount(),
                            'url' => array('user/friends', 'user_id' => $this->user->id),
                        ),
                        array(
                            'label' => '<span>Сейчас на сайте</span>' . $this->user->getFriendsCount(true),
                            'url' => array('user/blog', 'user_id' => $this->user->id, 'show' => 'online'),
                        ),
                        array(
                            'label' => '<span>Предложения дружбы</span>4',
                            'url' => array('albums/user', 'id' => $this->user->id, 'show' => 'incoming'),
                        ),
                        array(
                            'label' => '<span>Мои предложения</span>4',
                            'url' => array('user/friends', 'user_id' => $this->user->id, 'show' => 'outgoing'),
                        ),
                    ),
                    'encodeLabel' => false,
                ));
            ?>
        </div>

    </div>

    <div class="col-23 clearfix">

        <div class="content-title">Друзья</div>

        <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_friend',
                'template' => '<div class="friends clearfix"><ul>{items}</ul></div>{pager}'
            ));
        ?>

    </div>

</div>