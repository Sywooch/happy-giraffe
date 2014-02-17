<script type="text/html" id="search-template"><!-- -->
<div class="friends-list_li" data-bind="fadeVisible: userIsVisible">
    <div class="friends-list_i">
        <div class="b-ava-large">
            <div class="b-ava-large_ava-hold clearfix">
                <a href="" class="ava ava__large" data-bind="attr: { href : user.url() }, css: user.avaClass()"><span class="ico-status"></span><img alt="" class="ava_img" data-bind="visible: user.ava, attr: { src : user.ava }"/></a>
                <span class="b-ava-large_online" data-bind="visible: user.online">На сайте</span>
                <a href="" title="Начать диалог" class="b-ava-large_bubble b-ava-large_bubble__dialog" data-bind="attr: { href : user.dialogUrl() }"><span class="b-ava-large_ico b-ava-large_ico__mail"></span><span class="b-ava-large_bubble-tx"></span></a>
                <a href="" title="Фотографии" class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="attr: { href : user.albumsUrl() }, visible: user.hasPhotos"><span class="b-ava-large_ico b-ava-large_ico__photo"></span><span class="b-ava-large_bubble-tx" data-bind="text: user.photoCount"></span></a>
                <a href="" title="Записи в блоге" class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="attr: { href : user.blogUrl() }, visible: user.hasBlog"><span class="b-ava-large_ico b-ava-large_ico__blog"></span><span class="b-ava-large_bubble-tx" data-bind="text: user.blogPostsCount"></span></a>
                <a href="" title="Добавить в друзья" class="b-ava-large_bubble b-ava-large_bubble__friend-add" data-bind="click: clickHandler"><span class="b-ava-large_ico b-ava-large_ico__friend-add"></span><span class="b-ava-large_bubble-tx"> </span></a>
            </div>
            <div class="textalign-c"><a href="" class="b-ava-large_a" data-bind="text: user.fullName(), attr: { href : user.url() }"></a><span class="b-ava-large_age" data-bind="visible: user.age, text: user.age"></span></div>
            <div class="location location__small clearfix" data-bind="visible: user.location !== null, html: user.location"></div>
            <div class="b-family" data-bind="visible: user.family !== null, html: user.family"></div>
        </div>
        <!-- ko if: $data.constructor.name == 'IncomingFriendRequest' -->
        <div class="friend-offer">
            <div class="friend-offer_hold">
                <div class="friend-offer_btns"><a class="btn-green-simple btn-s" data-bind="click: accept">Принять</a><a href="" title="Отклонить" data-bind="click: decline" class="ico-cancel powertip">&#8211;</a></div>
            </div>
        </div>
        <!-- /ko -->
        <div class="cap-empty cap-empty__abs cap-empty__white" data-bind="visible: constructor.name == 'IncomingFriendRequest' && removed()">
            <div class="cap-empty_hold">
                <div class="cap-empty_img"></div>
                <div class="cap-empty_t">Вы отклонили <br> предложение </div>
            </div>
            <div class="verticalalign-m-help"></div>
        </div>
        <div class="cap-empty cap-empty__abs cap-empty__white" data-bind="visible: constructor.name == 'IncomingFriendRequest' && accepted()">
            <div class="cap-empty_hold">
                <div class="cap-empty_img cap-empty_img__smile-gray"></div>
                <div class="cap-empty_t">Теперь вы друзья!</div>
            </div>
            <div class="verticalalign-m-help"></div>
        </div>
    </div>
</div>
</script>