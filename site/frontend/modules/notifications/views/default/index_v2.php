<div class="layout-wrapper_frame clearfix display-n" id="notifications" data-bind="css: {'display-n': false}">
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
        require(['notifications', 'scrollEvents']);
    </script>
    <div class="u-notice">
        <!-- side-menu-->
        <div class="side-menu side-menu__notice">
            <div class="side-menu_hold">
                <div class="side-menu_t side-menu_t__notice"></div>
                <ul class="side-menu_ul">
                    <li class="side-menu_li" data-bind="css: {active: tab() == 0}"><a href="?read=0" class="side-menu_i" data-bind="/*click: function() { changeTab(0); }*/"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__notice"></span><span class="side-menu_tx">Новые </span><span class="side-menu_count" data-bind="text: unreadCount, visible: unreadCount()"></span></span><span class="verticalalign-m-help"></span></a></li>
                    <li class="side-menu_li" data-bind="css: {active: tab() == 1}"><a href="?read=1" class="side-menu_i" data-bind="/*click: function() { changeTab(1); }*/"><span class="side-menu_i-hold"><span class="side-menu_ico side-menu_ico__notice-arhive"></span><span class="side-menu_tx">Архив</span></span><span class="verticalalign-m-help"></span></a></li>
                </ul>
            </div>
        </div>
        <!-- /side-menu-->
        <div class="page-col page-col__notice">
            <div class="page-col_top">
                <div class="page-col_t-tx">Новые сигналы</div><!--<a href="" class="u-notice_a-settings">Настройте сигналы</a>--><a href="" class="u-notice_a-arhive" data-bind="click: markAllAsReaded"><span class="u-notice_a-arhive-tx">Отметить всё как прочитанное</span><span class="ico-check-gray"></span></a>
            </div>
            <div class="page-col_cont">
                <div class="u-notice_hold scroll">
                    <div class="scroll_scroller" data-bind="show: {selector: 'li:gt(-5)', callback: load}">
                        <div class="scroll_cont">
                            <div class="cap-empty cap-empty__abs" data-bind="visible: notifications().length == 0, css: {'cap-empty__notice-new': tab() == 0, 'cap-empty__notice-arhive': tab() == 1}">
                                <div class="cap-empty_hold">
                                    <div class="cap-empty_img"></div>
                                    <div class="cap-empty_t" data-bind="visible: tab() == 0">У вас пока нет сигналов.</div>
                                    <div class="cap-empty_t" data-bind="visible: tab() == 1">Архив пуст</div>
                                </div>
                                <div class="verticalalign-m-help"></div>
                            </div>
                            <ul class="u-notice_ul" data-bind="foreach: notifications">
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold">
                                        <!-- ko module: { name: 'notification-tile', data: $data, template: 'notification/' + type } -->
                                        <!-- /ko -->
                                        <a href="" class="u-notice_b u-notice_check" data-bind="click: setReaded, visible: $root.tab() == 0">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">Прочитано</div>
                                        </a>
                                    </div>
                                    <div class="u-notice_overlay" data-bind="css: {'display-b': readed}">
                                        <div class="u-notice_overlay-tx">Сигнал отмечен как прочитанный</div>
                                    </div>
                                </li>
                            </ul>
                            <div class="im_loader" data-bind="visible: loading"><img src="/new/images/ico/ajax-loader.gif" alt="" class="im_loader-img"><span class="im_loader-tx">Загрузка ранних уведомлений</span></div>
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
$data = HJSON::encode($_data_);
Yii::app()->clientScript->registerAMD('notificationsVM', array('Notification' => 'ko_notifications', 'ko' => 'knockout'), "ko.applyBindings(new Notification(" . $data . "), document.getElementById('notifications')); console.log(" . $data . ");");
?>