<script type="text/html" id="user-template">
    <div class="friends-list_i">
        <div class="b-ava-large">
            <div class="b-ava-large_ava-hold clearfix">
                <a class="ava large" data-bind="attr: { href : user.url() }, css: user.avaClass()">
                    <img alt="" data-bind="visible: user.ava, attr: { src : user.ava }">
                </a>
                <span class="b-ava-large_online" data-bind="visible: user.online">На сайте</span>
                <a class="ico-close2 b-ava-large_close" data-bind="click: remove, tooltip: 'Удалить из друзей'"></a>
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
            <span class="b-ava-large_bubble b-ava-large_bubble__friend">
                <span class="b-ava-large_ico b-ava-large_ico__friend"></span>
                <span class="b-ava-large_bubble-tx">друг</span>
            </span>
            </div>
            <div class="textalign-c">
                <a class="b-ava-large_a" data-bind="text: user.fullName(), attr: { href : user.url() }"></a>
            </div>
        </div>

        <div class="friends-list_group">
            <a class="friends-list_group-a" onclick="$(this).next().toggle()" data-bind="visible: $root.lists().length > 0, text: listLabel"></a>
            <div class="friends-list_group-popup">
                <a class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="click: unbindList, visible: listId() !== null">Все друзья</a>
                <!-- ko foreach: $root.lists -->
                <a class="friends-list_group-popup-a" onclick="$(this).parent().hide()" data-bind="text: title, click: $parent.bindList, visible: $parent.listId() != id()"></a>
                <!-- /ko -->
            </div>
        </div>

        <div class="friends-list_deleted" data-bind="visible: removed">
            <div class="friends-list_deleted-hold">
                <a class="friends-list_a" data-bind="text: user.fullName(), attr: { href : user.url() }"></a>
                <div class="friends-list_row color-gray">удалена из списка <br>ваших друзей</div>
                <a class="a-pseudo" data-bind="click: restore">Восстановить?</a>
            </div>
        </div>
    </div>
</script>