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
                <div class="page-col_t-tx">Новые сигналы</div><!--<a href="" class="u-notice_a-settings">Настройте сигналы</a>--><a href="" class="u-notice_a-arhive" data-bind="click: markAllAsReaded"><span class="u-notice_a-arhive-tx">Отметить всё как прочитанное</span><span class="ico-check-gray"></span></a>
            </div>
            <div class="page-col_cont">
                <div class="u-notice_hold scroll">
                    <div class="scroll_scroller">
                        <div class="scroll_cont">
                            <ul class="u-notice_ul" data-bind="foreach: notifications">
                                <li class="u-notice_li">
                                    <div class="u-notice_li-hold">
                                        <!-- ko module: { name: 'notification-tile', data: $data, template: 'notification/' + type } -->
                                        <!-- /ko -->
                                        <a href="" class="u-notice_b u-notice_check" data-bind="click: setReaded">
                                            <div class="ico-check-gray"></div>
                                            <div class="u-notice_check-tx">Прочитано</div>
                                        </a>
                                    </div>
                                    <div class="u-notice_overlay" data-bind="css: {'display-b': readed}">
                                        <div class="u-notice_overlay-tx">Сигнал отмечен как прочитанный</div>
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
$data = HJSON::encode($_data_, array(
        'NotificationSummary' => array(
            "type",
            "updated",
            "count",
            "visibleCount",
            "articles" => array(
                'NotificationArticle' => array(
                    'entity',
                    'entity_id',
                    'count',
                    'model',
                )
            ),
        ),
        'NotificationReplyComment' => array(
            "type",
            "entity_id",
            "updated",
            "count",
            "visibleCount",
            "url",
            "relatedModel" => array(
                'CModel' => array(
                    'id',
                    'author' => array(
                        'User' => array(
                            'id',
                            'avaOrDefaultImage',
                        ),
                    ),
                    'created',
                    'title',
                    'type_id',
                    'powerTipTitle',
                    'contentTitle',
                ),
            ),
            'comment' => array(
                'Comment' => array(
                    'text'
                ),
            ),
        ),
        'Notification' => array(
            "type",
            "entity_id",
            "updated",
            "count",
            "visibleCount",
            "url",
            "relatedModel" => array(
                'CModel' => array(
                    'id',
                    'author' => array(
                        'User' => array(
                            'id',
                            'avaOrDefaultImage',
                        ),
                    ),
                    'created',
                    'title',
                    'type_id',
                    'powerTipTitle',
                    'contentTitle',
                ),
            ),
        ),
    ));
Yii::app()->clientScript->registerAMD('notificationsVM', array('Notification' => 'ko_notifications', 'ko' => 'knockout'), "ko.applyBindings(new Notification(" . $data . "), document.getElementById('notifications')); console.log(" . $data . ");");
?>