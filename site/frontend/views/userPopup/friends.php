<div id="user-friends" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Друзья</span>
        </div>

        <a href="javascript:void(0)" onclick="Friends.close()" class="close">Закрыть вкладку</a>

    </div>

    <div class="friends activity-find-friend">

    <div class="invitation">

        <div class="friends-count">18 <a href="javascript:void(0)" class="more"><i class="icon"></i></a></div>

        <div class="block-title">У вас новые предложения дружбы</div>

        <?php
            $this->widget('zii.widgets.CListView', array(
                'id' => 'friendRequestList',
                'dataProvider' => $requests,
                'itemView' => '//user/_friendRequest',
                'itemsTagName' => 'ul',
                'template' =>
                '
                        <div class="friends clearfix">
                            {items}
                        </div>
                        <div class="pagination pagination-center clearfix">
                            {pager}
                        </div>
                    ',
                'pager' => array(
                    'class' => 'MyLinkPager',
                    'header' => '',
                ),
                'viewData' => array(
                    'direction' => 'incoming',
                ),
            ));
        ?>

    </div>

    <div class="find-friend">


        <div class="block-title"><?=($hasInvitations) ? 'Возможно вам будет интересно подружиться' : 'У вас пока нет новых друзей. Возможно вам будет интересно подружиться'?></div>

        <ul>

            <?php foreach ($findFriends as $f): ?>
                <?php $this->renderPartial('application.widgets.activity.views._friend', array('f' => $f, 'full' => false)); ?>
            <?php endforeach; ?>

        </ul>

    </div>

    </div>

    <div class="recent clearfix">

        <div class="recent-friend">

            <div class="block-title">Мои друзья</div>

            <div class="clearfix">

                <div class="user-info medium">
                    <a class="ava female"></a>
                    <div class="details">
                        <span class="icon-status status-online"></span>
                        <a href="" class="username">Богоявленский Александр</a>
                        <div class="user-fast-buttons">
                            <span class="friend">друг</span>
                            <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                        </div>
                    </div>
                </div>

                <div class="become-friends"><i class="icon"></i>Подружились</div>

                <div class="date">Сегодня<br/>13:25</div>

            </div>

            <div class="all-link">
                <a href=""><i class="icon"></i>Все мои друзья (26)</a>
            </div>

        </div>

        <div class="news">

            <?php if (empty($news)): ?>

                <div class="empty"><i class="icon"></i>Здесь скоро появятся<br/>новости моих друзей</div>

            <?php else: ?>

                <div class="block-title">Что нового у моих друзей</div>

                <ul>
                    <?php foreach ($news as $n): ?>
                        <li>
                            <div class="date"><?php echo HDate::GetFormattedTime($n->updated); ?></div>
                            <div class="in">
                                <div class="user">
                                    <a href="" class="ava small"></a>
                                    <span class="icon-status status-online"></span>
                                </div>
                                <div class="text">
                                    <?=$n->text?>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="all-link">
                    <?=CHtml::link('<i class="icon"></i>Все новости моих друзей', array('user/activity', 'user_id' => Yii::app()->user->id, 'type' => 'friends'))?>
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>