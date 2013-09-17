<script type="text/html" id="request-template">
    <div class="friends-list_i" data-bind="fadeVisible: userIsVisible">
        <div class="b-ava-large" >
            <div class="b-ava-large_ava-hold clearfix">
                <a class="ava large" data-bind="attr: { href : user.url() }, css: user.avaClass()">
                    <img alt="" data-bind="visible: user.ava, attr: { src : user.ava }">
                </a>
                <span class="b-ava-large_online" data-bind="visible: user.online">На сайте</span>
                <a class="b-ava-large_bubble b-ava-large_bubble__dialog" data-bind="attr: { href : user.dialogUrl() }, tooltip: 'Начать диалог'">
                    <span class="b-ava-large_ico b-ava-large_ico__mail"></span>
                    <!--<span class="b-ava-large_bubble-tx">+5</span>-->
                </a>
                <a class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="attr: { href : user.albumsUrl() }, tooltip: 'Фотографии', visible: user.hasPhotos">
                    <span class="b-ava-large_ico b-ava-large_ico__photo"></span>
                    <span class="b-ava-large_bubble-tx" data-bind="text: user.photoCount"></span>
                </a>
                <a class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="attr: { href : user.blogUrl() }, tooltip: 'Записи в блоге', visible: user.hasBlog">
                    <span class="b-ava-large_ico b-ava-large_ico__blog"></span>
                    <span class="b-ava-large_bubble-tx" data-bind="text: user.blogPostsCount"></span>
                </a>
                <!-- ko if: $data.constructor.name == 'IncomingFriendRequest' -->
            <span class="b-ava-large_bubble b-ava-large_bubble__friend">
                <span class="b-ava-large_ico b-ava-large_ico__friend"></span>
                <a class="b-ava-large_plus" data-bind="click: accept, tooltip: 'Принять'"></a>
                <a class="b-ava-large_minus" data-bind="click: decline, tooltip: 'Отказаться'"></a>
            </span>
                <!-- /ko -->
                <!-- ko if: $data.constructor.name == 'OutgoingFriendRequest' -->
                <a class="b-ava-large_bubble" data-bind="tooltip: tooltipText, css: aCssClass, click: clickHandler">
                    <span class="b-ava-large_ico" data-bind="css: spanCssClass"></span>
                </a>
                <!-- /ko -->
            </div>
            <div class="textalign-c">
                <a class="b-ava-large_a" data-bind="text: user.fullName(), attr: { href : user.url() }"></a>
                <!-- ko if: user.age !== null -->
                <span class="font-smallest color-gray" data-bind="text: user.age"></span>
                <!-- /ko -->
            </div>
        </div>
        <!-- ko if: user.location !== null -->
        <div class="friends-list_location clearfix" data-bind="html: user.location"></div>
        <!-- /ko -->
        <!-- ko if: user.family !== null -->
        <div class="b-family" data-bind="html: user.family"></div>
        <!-- /ko -->
        <!-- ko if: $data.constructor.name == 'IncomingFriendRequest' && removed() -->
        <div class="cap-empty">
            <div class="cap-empty_hold">
                <div class="cap-empty_tx">Вы отклонили предложение дружбы</div>
                <span class="cap-empty_gray">Пользователь успешно <br> удален из этого списка</span>
                <div class="clearfix">
                    <a class="a-pseudo" data-bind="click: restore">Восстановить?</a>
                </div>
            </div>
        </div>
        <!-- /ko -->

        <!-- ko if: $data.constructor.name == 'OutgoingFriendRequest' && invited() -->
        <div class="cap-empty cap-empty__smile">
            <div class="cap-empty_hold">
                <div class="cap-empty_tx">Приглашение <br> отправлено </div>
            </div>
        </div>
        <!-- /ko -->
    </div>
</script>