<div id="user-friends" class="clearfix">

    <div class="header">

        <div class="title">
            <span>Друзья</span>
        </div>

        <a href="javascript:void(0)" onclick="Friends.close()" class="close">Закрыть вкладку</a>

    </div>

    <div class="friends activity-find-friend">

        <?php if ($hasInvitations || $ajax == 'friendRequestList'): ?>
            <div class="invitation">

                <div class="friends-count"><span><?=$requests->itemCount?></span> <a href="javascript:void(0);" onclick="Friends.friendsCarousel.jcarousel('scroll', '+=4');" class="more"<?php if ($requests->itemCount <= 4): ?> style="display: none;"<?php endif; ?>><i class="icon"></i></a></div>

                <div class="block-title">У вас новые предложения дружбы</div>

                <?php
                    $this->widget('zii.widgets.CListView', array(
                        'id' => 'friendRequestList',
                        'dataProvider' => $requests,
                        'itemView' => '//user/_friendRequest',
                        'itemsTagName' => 'ul',
                        'template' => '{items}',
                        'viewData' => array(
                            'direction' => 'incoming',
                        ),
                        'htmlOptions' => array(
                            'class' => 'jcarousel',
                        ),
                    ));
                ?>
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

                    <?=CHtml::link('Найти<br/>друзей', array('/friends/find'), array('class' => 'btn-green'))?>

                </div>

                <p>Вы можете найти друзей по интересам, по месту жительства, по похожему семейному положению, отправить им приглашение дружбы или просто написать им.<br/><br/>Желаем вам найти много друзей! Удачи!</p>

            </div>

        <?php else: ?>

            <div class="recent-friend">

                <div class="block-title">Мои друзья <a href="<?=$this->createUrl('user/friends', array('user_id' => Yii::app()->user->id))?>">Все друзья (<span><?=$friendsCount?></span>)</a></div>

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

                    <div class="date"><?=HDate::GetFormattedTime($lastFriend->fCreated)?></div>

                </div>

                <div class="all-link">
                    <a href="<?=$this->createUrl('/friends/find')?>"><i class="icon"></i>Найти еще друзей</a>
                </div>

            </div>

            <div class="news">

                <?php if (empty($news)): ?>

                    <div class="empty"><i class="icon"></i>Здесь скоро появятся<br/>новости моих друзей</div>

                <?php else: ?>

                    <div class="block-title">Что нового у моих друзей</div>

                    <ul>
                        <?php $i = 0; foreach ($news as $n): ?>
                            <?php if ($n->text !== null): ?>
                            <?php $initiator = User::model()->findByPk($n->user_id) ?>
                                <li style="display: none;">
                                    <div class="date"><?php echo HDate::GetFormattedTime($n->updated); ?></div>
                                    <div class="in">
                                        <div class="user">
                                            <?php $this->widget('application.widgets.avatarWidget.AvatarWidget', array(
                                                'user' => $initiator,
                                                'small' => true,
                                                'size' => 'small',
                                            )); ?>
                                            <span class="icon-status status-<?=($initiator->online) ? 'online' : 'offline'?>"></span>
                                        </div>
                                        <div class="text">
                                            <?=$n->text?>
                                        </div>
                                    </div>
                                </li>
                                <?php $i++; if ($i == 6) break; ?>
                            <?php endif; ?>
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