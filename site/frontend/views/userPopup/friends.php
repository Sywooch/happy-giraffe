<div id="user-friends" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Друзья</span>
        </div>

        <a href="" class="close">Закрыть вкладку</a>

    </div>

    <div class="friends activity-find-friend">

        <?php if ($hasInvitations): ?>
            <div class="invitation">

                <div class="friends-count"><span><?=$requests->itemCount?></span> <a href="javascript:void(0);" onclick="Friends.friendsCarousel.jcarousel('scroll', '+=1');" class="more"><i class="icon"></i></a></div>

                <div class="block-title">У вас новые предложения дружбы</div>

                <div class="jcarousel">
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
            </div>
        <?php endif; ?>

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

        <?php if ($friendsCount == 0): ?>

            <div class="find">

                <div class="block-title">Найти друзей</div>

                <div class="button">

                    <?=CHtml::link('Найти<br/>друзей', array('activity/friends'), array('class' => 'btn-green'))?>

                </div>

                <p>Вы можете найти друзей по интересам, по месту жительства, по похожему семейному положению, отправить им приглашение дружбы или просто написать им.<br/><br/>Желаем вам найти много друзей! Удачи!</p>

            </div>

        <?php else: ?>

            <div class="recent-friend">

                <div class="block-title">Мои друзья</div>

                <div class="clearfix">
                    <div id="moveFriendArea">

                        <div class="clearfix">
                            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                'user' => $lastFriend,
                                'location' => false,
                                'friendButton' => true,
                            )); ?>
                        </div>

                    </div>

                    <div class="become-friends"><i class="icon"></i>Подружились</div>

                    <div class="date">Сегодня<br/>13:25</div>

                </div>

                <div class="all-link">
                    <a href=""><i class="icon"></i>Все мои друзья (<span id="friendsCount"><?=$friendsCount?></span>)</a>
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
                                <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                    'user' => $c->contentAuthor,
                                    'size' => 'small',
                                    'sendButton' => false,
                                    'location' => false,
                                )); ?>
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

        <?php endif; ?>

    </div>

</div>