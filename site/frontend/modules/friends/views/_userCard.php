<script type="text/html" id="request-template">
    <div class="friends-list_li">
        <div class="friends-list_i"><span title="Удалить из друзей" class="ico-close2 powertip"></span>
            <!-- b-ava-large-->
            <div class="b-ava-large">
                <div class="b-ava-large_ava-hold clearfix">
                    <a href="" class="ava ava__large" data-bind="attr: { href : user.url() }, css: user.avaClass()"><span class="ico-status"></span><img alt="" src="/new/images/example/ava-large.jpg" class="ava_img" data-bind="visible: user.ava, attr: { src : user.ava }"/></a>
                    <span class="b-ava-large_online" data-bind="visible: user.online">На сайте</span>
                    <a href="" title="Начать диалог" class="b-ava-large_bubble b-ava-large_bubble__dialog"><span class="b-ava-large_ico b-ava-large_ico__mail"></span><span class="b-ava-large_bubble-tx"></span></a>
                    <a href="" title="Фотографии" class="b-ava-large_bubble b-ava-large_bubble__photo" data-bind="attr: { href : user.albumsUrl() }, visible: user.hasPhotos"><span class="b-ava-large_ico b-ava-large_ico__photo"></span><span class="b-ava-large_bubble-tx" data-bind="text: user.photoCount"></span></a>
                    <a href="" title="Записи в блоге" class="b-ava-large_bubble b-ava-large_bubble__blog" data-bind="attr: { href : user.blogUrl() }, visible: user.hasBlog"><span class="b-ava-large_ico b-ava-large_ico__blog"></span><span class="b-ava-large_bubble-tx" data-bind="text: user.blogPostsCount"></span></a>
                    <a href="" title="Друг" class="b-ava-large_bubble b-ava-large_bubble__friend"><span class="b-ava-large_ico b-ava-large_ico__friend"></span><span class="b-ava-large_bubble-tx">Друг</span></a>
                </div>
                <div class="textalign-c"><a href="" class="b-ava-large_a" data-bind="text: user.fullName(), attr: { href : user.url() }"></a><span class="b-ava-large_age" data-bind="visible: user.age, text: user.age"></span></div>
                <!-- ko if: user.location !== null -->
                <div class="location location__small clearfix" data-bind="html: user.location"></div>
                <!-- /ko -->
                <!-- ko if: user.family !== null -->
                <div class="b-family" data-bind="html: user.family"></div>
                <!-- /ko -->
            </div>
            <!-- /b-ava-large-->
        </div>
    </div>
</script>