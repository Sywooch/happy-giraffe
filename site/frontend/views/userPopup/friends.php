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


        <div class="block-title"><?($hasInvitations) ? 'Возможно вам будет интересно подружиться' : 'У вас пока нет новых друзей. Возможно вам будет интересно подружиться' ?></div>

        <ul>

            <li>

                <div class="clearfix">
                    <div class="user-info medium">
                        <a class="ava female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Богоявленский</a>
                            <div class="user-fast-buttons">
                                <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info">

                    <p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия</span></p>

                    <p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>

                </div>

            </li>

            <li>

                <div class="clearfix">
                    <div class="user-info medium">
                        <a class="ava female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Богоявленский</a>
                            <div class="user-fast-buttons">
                                <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info">

                    <p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия</span></p>

                    <p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>

                </div>

            </li>

            <li>

                <div class="clearfix">
                    <div class="user-info medium">
                        <a class="ava female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Богоявленский</a>
                            <div class="user-fast-buttons">
                                <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info">

                    <p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия</span></p>

                    <p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>

                </div>

            </li>

            <li>

                <div class="clearfix">
                    <div class="user-info medium">
                        <a class="ava female"></a>
                        <div class="details">
                            <span class="icon-status status-online"></span>
                            <a href="" class="username">Богоявленский Александр</a>
                            <div class="user-fast-buttons">
                                <a href="" class="add-friend"><span class="tip">Пригласить в друзья</span></a>
                                <a href="" class="new-message"><span class="tip">Написать сообщение</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="info">

                    <p class="location"><span class="flag-big flag-big-ru"></span> <span>Россия, Россия, Россия, Россия, Россия, Россия</span></p>

                    <p>35 лет, замужем &nbsp; <i class="icon-kid-boy"></i> <i class="icon-kid-girl"></i> <i class="icon-kid-wait"></i></p>

                </div>

            </li>

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

            <div class="block-title">Что нового у моих друзей</div>

            <ul>
                <li>
                    <div class="date">Сегодня<br/>13:25</div>
                    <div class="in">
                        <div class="user">
                            <a href="" class="ava small"></a>
                            <span class="icon-status status-online"></span>
                        </div>
                        <div class="text">
                            <a href="">Александра Богоявленская</a> добавила новые фото <b>в альбом <a href="">Зимние каникулы</a></b>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="date">Сегодня<br/>13:25</div>
                    <div class="in">
                        <div class="user">
                            <a href="" class="ava small"></a>
                            <span class="icon-status status-offline"></span>
                        </div>
                        <div class="text">
                            <a href="">Ирина</a> добавила запись <b>в клубе <a href="">Ранее развитие и обучение</a></b>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="date">Сегодня<br/>13:25</div>
                    <div class="in">
                        <div class="user">
                            <a href="" class="ava small"></a>
                            <span class="icon-status status-offline"></span>
                        </div>
                        <div class="text">
                            <a href="">Виктория</a> оставила комментарий <b>в блоге <span class="user"><span class="icon-status status-online"></span> <a href="">Настя</a></span> <a href="">Как построить бревенчатый дом. Нюансы, тонкости, приспособления</a></b>
                        </div>
                    </div>
                </li>

            </ul>

            <div class="all-link">
                <a href=""><i class="icon"></i>Все новости моих друзей</a>
            </div>

        </div>

    </div>

</div>