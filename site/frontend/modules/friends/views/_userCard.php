<script type="text/html" id="user-template"><!-- -->
    <li class="friends-list_li friends-list_banner"><a href="<?=$this->createUrl('/friends/search')?>"><img src="/new/images/banner/friends-list_banner.png"></a></li>
    <li class="friends-list_li">
        <div class="friends-list_i">
            <span data-bind="visible: !removed(), click: remove" title="Удалить из друзей" class="ico-close2 powertip"></span>
            <div class="b-ava-large">
                <div class="b-ava-large_ava-hold clearfix">
                    <a href="" class="ava ava__large" data-bind="attr: { href : user.url() }, css: user.avaClass()"><span class="ico-status"></span><img alt="" class="ava_img" data-bind="visible: user.ava, attr: { src : user.ava }"/></a>
                    <span class="b-ava-large_online" data-bind="visible: user.online">На сайте</span>
                    <a href="" title="Начать диалог" class="b-ava-large_bubble b-ava-large_bubble__dialog" data-bind="module: 'fast-message', attr: { 'data-fast-message-for': user.id }"><span class="b-ava-large_ico b-ava-large_ico__mail"></span><span class="b-ava-large_bubble-tx"></span></a>
                    <a href="" title="Фотографии" class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="attr: { href : user.albumsUrl() }, visible: user.hasPhotos"><span class="b-ava-large_ico b-ava-large_ico__photo"></span><span class="b-ava-large_bubble-tx" data-bind="text: user.photoCount"></span></a>
                    <a href="" title="Записи в блоге" class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="attr: { href : user.blogUrl() }, visible: user.hasBlog"><span class="b-ava-large_ico b-ava-large_ico__blog"></span><span class="b-ava-large_bubble-tx" data-bind="text: user.blogPostsCount"></span></a>
                    <a href="" title="Друг" class="b-ava-large_bubble b-ava-large_bubble__friend"><span class="b-ava-large_ico b-ava-large_ico__friend"></span><span class="b-ava-large_bubble-tx">Друг</span></a>
                </div>
                <div class="textalign-c"><a href="" class="b-ava-large_a" data-bind="text: user.fullName(), attr: { href : user.url() }"></a><span class="b-ava-large_age" data-bind="visible: user.age, text: user.age"></span></div>
                <div class="location location__small clearfix" data-bind="visible: user.location !== null, html: user.location"></div>
                <div class="b-family" data-bind="visible: user.family !== null, html: user.family"></div>
            </div>
            <div class="cap-empty cap-empty__abs cap-empty__white" data-bind="visible: removed">
                <div class="cap-empty_hold">
                    <div class="cap-empty_img"></div>
                    <div class="cap-empty_tx-top"><a href='' class='b-ava-large_a' data-bind="text: user.fullName(), attr: { href : user.url() }"></a></div>
                    <div class="cap-empty_t">Удален из друзей</div>
                    <div class="cap-empty_tx-sub"><a href='' data-bind="click: restore">Восстановить</a></div>
                </div>
                <div class="verticalalign-m-help"></div>
            </div>
        </div>
    </li>
</script>
