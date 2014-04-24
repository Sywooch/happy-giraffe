<div class="layout-wrapper_frame clearfix" id="notifications">
    <script>
        define('notifications', ['common'], function() {
            return new function() {
                var self = this;
                function noticeHeight() {
                    // 58 - шапка, что не скролится
                    // 40 - отступы снизу + сверху
                    var h = self.windowHeight - self.headerHeight - 58 - 40;
                    if (h < 350) {
                        h = 350;

                    }
                    self.contentBlock.height(h);
                }
                self.renew = function() {
                    self.windowHeight = $(window).height();
                    self.headerHeight = $('.layout-header').height();
                    noticeHeight();
                    addBaron('.scroll');
                }

                $(window).resize(function() {
                    self.renew();
                });


                $(document).ready(function() {
                    var contentBlock = ".u-notice_hold";
                    self.contentBlock = $(contentBlock);
                    self.renew();
                });

            }();
        });
        require(['notifications']);
    </script>
    <div class="u-notice">
        <!-- side-menu-->
        <div class="side-menu side-menu__notice">
            <div class="side-menu_hold">
                <div class="side-menu_t side-menu_t__notice"></div>
                <ul class="side-menu_ul">
                    <li class="side-menu_li"><a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__notice"></span><span class="side-menu_tx">Новые </span><span class="side-menu_count">154</span></span><span class="verticalalign-m-help"></span></a></li>
                    <li class="side-menu_li active"><a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__notice-arhive"></span><span class="side-menu_tx">Архив</span></span><span class="verticalalign-m-help"></span></a></li>
                    <li class="side-menu_li"><a href="" class="side-menu_i"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__hg"></span><span class="side-menu_tx">Веселый </br> Жираф!</span></span></a></li>
                </ul>
            </div>
        </div>
        <!-- /side-menu-->
        <div class="page-col page-col__notice">
            <div class="page-col_top">
                <div class="page-col_t-tx">Новые сигналы</div><a href="" class="u-notice_a-settings">Настройте сигналы</a><a href="" class="u-notice_a-arhive"><span class="u-notice_a-arhive-tx">Отправить все в архив</span><span class="ico-check-gray"></span></a>
            </div>
            <div class="page-col_cont">
                <div class="u-notice_hold scroll">
                    <div class="scroll_scroller">
                        <div class="scroll_cont">
                            <ul class="u-notice_ul">
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold">
                                        <!-- Виды иконок-->
                                        <!-- u-notice_ico__favorite-->
                                        <!-- u-notice_ico__answer-->
                                        <!-- u-notice_ico__comment-->
                                        <!-- u-notice_ico__like-->
                                        <!-- u-notice_ico__discus-->
                                        <!-- u-notice_ico__answer-q--><a href="" class="u-notice_b u-notice_ico u-notice_ico__favorite"></a><a href="" class="u-notice_b u-notice_spec">
                                            <div class="u-notice_b u-notice_count">15</div>
                                            <div class="u-notice_b u-notice_desc">В избранное
                                                <div class="u-notice_desc-go"> Перейти</div>
                                            </div></a>
                                        <div class="u-notice_b u-notice_users">
                                            <div class="ava-list">
                                                <ul class="ava-list_ul">
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a class="ava-list_last-tx">еще 11</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Виды иконок-->
                                        <!-- u-notice_post-ico__post-->
                                        <!-- u-notice_post-ico__comment-->
                                        <!-- u-notice_post-ico__video-->
                                        <!-- u-notice_post-ico__photo-->
                                        <!-- u-notice_post-ico__question--><a href="" class="u-notice_b u-notice_post-ico u-notice_post-ico__post"></a>
                                        <div class="u-notice_b u-notice_post"><a href="" class="u-notice_post-a">Отдых в России: куда поехать на майские праздники</a></div><a href="" class="u-notice_b u-notice_check">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">В архив</div></a>
                                    </div>
                                    <div class="u-notice_overlay">
                                        <div class="u-notice_overlay-tx">Сигнал перемещен в архив</div>
                                    </div>
                                </li>
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold"><a href="" class="u-notice_b u-notice_ico u-notice_ico__answer"></a><a href="" class="u-notice_b u-notice_spec">
                                            <div class="u-notice_b u-notice_count">15</div>
                                            <div class="u-notice_b u-notice_desc">Ответов на ваш <br/> комментарий
                                                <div class="u-notice_desc-go"> Перейти</div>
                                            </div></a>
                                        <div class="u-notice_b u-notice_users">
                                            <div class="ava-list">
                                                <ul class="ava-list_ul">
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a class="ava-list_last-tx">еще 1</a></li>
                                                </ul>
                                            </div>
                                        </div><a href="" class="u-notice_b u-notice_post-ico u-notice_post-ico__comment"></a>
                                        <div class="u-notice_b u-notice_post"><a href="" class="u-notice_comment">Телец часто противоречив, вспыльчив и импульсивен.Обладая поистине неисчерпаемым ...</a></div><a href="" class="u-notice_b u-notice_check">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">В архив</div></a>
                                    </div>
                                    <div class="u-notice_overlay">
                                        <div class="u-notice_overlay-tx">Сигнал перемещен в архив</div>
                                    </div>
                                </li>
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold"><a href="" class="u-notice_b u-notice_ico u-notice_ico__comment"></a><a href="" class="u-notice_b u-notice_spec">
                                            <div class="u-notice_b u-notice_count">15</div>
                                            <div class="u-notice_b u-notice_desc">Новых <br/> комментариев
                                                <div class="u-notice_desc-go"> Перейти</div>
                                            </div></a>
                                        <div class="u-notice_b u-notice_users">
                                            <div class="ava-list">
                                                <ul class="ava-list_ul">
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a class="ava-list_last-tx">еще 1456</a></li>
                                                </ul>
                                            </div>
                                        </div><a href="" class="u-notice_b u-notice_post-ico u-notice_post-ico__video"></a>
                                        <div class="u-notice_b u-notice_post"><a href="" class="a-user">Татьяна Богоявленская</a><br><a href="" class="u-notice_post-a">Отдых в России: куда поехать на майские праздники</a></div><a href="" class="u-notice_b u-notice_check">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">В архив</div></a>
                                    </div>
                                    <div class="u-notice_overlay">
                                        <div class="u-notice_overlay-tx">Сигнал перемещен в архив</div>
                                    </div>
                                </li>
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold"><a href="" class="u-notice_b u-notice_ico u-notice_ico__like"></a><a href="" class="u-notice_b u-notice_spec">
                                            <div class="u-notice_b u-notice_count">152</div>
                                            <div class="u-notice_b u-notice_desc">Нравится
                                                <div class="u-notice_desc-go"> Перейти</div>
                                            </div></a>
                                        <div class="u-notice_b u-notice_users">
                                            <div class="ava-list">
                                                <ul class="ava-list_ul">
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a class="ava-list_last-tx">еще 1</a></li>
                                                </ul>
                                            </div>
                                        </div><a href="" class="u-notice_b u-notice_post-ico u-notice_post-ico__photo"></a>
                                        <div class="u-notice_b u-notice_post"><a href="" class="u-notice_post-a">Фото 1</a></div><a href="" class="u-notice_b u-notice_check">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">В архив</div></a>
                                    </div>
                                    <div class="u-notice_overlay">
                                        <div class="u-notice_overlay-tx">Сигнал перемещен в архив</div>
                                    </div>
                                </li>
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold"><a href="" class="u-notice_b u-notice_ico u-notice_ico__discus"></a><a href="" class="u-notice_b u-notice_spec">
                                            <div class="u-notice_b u-notice_count">15</div>
                                            <div class="u-notice_b u-notice_desc">Продолжение <br> обсуждения
                                                <div class="u-notice_desc-go"> Перейти</div>
                                            </div></a>
                                        <div class="u-notice_b u-notice_users">
                                            <div class="ava-list">
                                                <ul class="ava-list_ul">
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a class="ava-list_last-tx">еще 1</a></li>
                                                </ul>
                                            </div>
                                        </div><a href="" class="u-notice_b u-notice_post-ico u-notice_post-ico__post"></a>
                                        <div class="u-notice_b u-notice_post"><a href="" class="a-user">Татьяна Богоявленская</a><br><a href="" class="u-notice_post-a">Отдых в России: куда поехать на майские праздники</a></div><a href="" class="u-notice_b u-notice_check">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">В архив</div></a>
                                    </div>
                                    <div class="u-notice_overlay display-b">
                                        <div class="u-notice_overlay-tx">Сигнал перемещен в архив</div>
                                    </div>
                                </li>
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold"><a href="" class="u-notice_b u-notice_ico u-notice_ico__answer-q"></a><a href="" class="u-notice_b u-notice_spec">
                                            <div class="u-notice_b u-notice_count">1</div>
                                            <div class="u-notice_b u-notice_desc">Ответов на <br> ваш вопрос
                                                <div class="u-notice_desc-go"> Перейти</div>
                                            </div></a>
                                        <div class="u-notice_b u-notice_users">
                                            <div class="ava-list">
                                                <ul class="ava-list_ul">
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a href="" class="ava ava__small ava__male"><span class="ico-status ico-status__online"></span><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></a>
                                                    </li>
                                                    <li class="ava-list_li"><a class="ava-list_last-tx">еще 1</a></li>
                                                </ul>
                                            </div>
                                        </div><a href="" class="u-notice_b u-notice_post-ico u-notice_post-ico__question"></a>
                                        <div class="u-notice_b u-notice_post"><a href="" class="u-notice_post-a">Отдых в России: куда поехать на майские праздники</a></div><a href="" class="u-notice_b u-notice_check">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">В архив</div></a>
                                    </div>
                                    <div class="u-notice_overlay">
                                        <div class="u-notice_overlay-tx">Сигнал перемещен в архив</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- scroll-bar-->
                    <div class="scroll_bar-hold">
                        <div class="scroll_bar">
                            <div class="scroll_bar-in"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
Yii::app()->clientScript->registerAMD('notificationsVM', array('Notification'=>'ko_notifications', 'ko'=>'knockout'), "ko.applyBindings(new Notification(" . CJSON::encode($_data_) . "), document.getElementById('notifications'));");
?>