<?php
    $model = AlbumPhoto::model()->findByPk($json['initialPhotoId']);
?>
<div class="photo-window" id="photo-window">
    <div class="photo-window_w">
        <a class="photo-window_close" data-bind="click: close"></a>

        <div class="photo-window_top">
            <div class="photo-window_count" data-bind="text: currentNaturalIndex() + ' из ' + count"></div>
        </div>
        <!-- Обрабатывать клик на .photo-window_c для листания следующего изображения -->
        <div class="photo-window_c">
            <div class="photo-window_img-hold" data-bind="click: nextHandler">
                <img alt="" class="photo-window_img" data-bind="attr: { src : currentPhoto().src }">
                <div class="verticalalign-m-help"></div>
            </div>
            <a class="photo-window_arrow photo-window_arrow__l" data-bind="click: prevHandler"></a>
            <a class="photo-window_arrow photo-window_arrow__r" data-bind="click: nextHandler"></a>

            <div class="like-control clearfix">
                <!-- ko with: currentPhoto() -->
                    <a href="" class="like-control_ico like-control_ico__like" data-bind="click: like, text: likesCount, css: {active: isLiked()}, tooltip: 'Нравится'" ></a>
                    <!-- ko with: favourites() -->
                        <?php $this->widget('FavouriteWidget', array('model' => $model, 'applyBindings' => false)); ?>
                    <!-- /ko -->
                <!-- /ko -->
            </div>

            <div class="contestData"></div>
        </div>



        <div class="photo-window_col">

            <div class="photo-window_col-hold scroll">
                <div class="scroll_scroller  photo-window_cont">
                    <div class="scroll_cont">
                        <div class="photo-window_cont-t clearfix">
                            <div class="meta-gray">
                                <a class="meta-gray_comment" href="">
                                    <span class="ico-comment ico-comment__gray"></span>
                                    <span class="meta-gray_tx" data-bind="text: currentPhoto().commentsCount"></span>
                                </a>
                                <div class="meta-gray_view">
                                    <span class="ico-view ico-view__gray"></span>
                                    <span class="meta-gray_tx" data-bind="text: currentPhoto().views"></span>
                                </div>
                            </div>
                            <div class="b-user-info b-user-info__middle float-l" data-bind="with: currentPhoto().user">
                                <a class="ava ava__middle" data-bind="attr: { href : url }, css: avaCssClass"><img class="ava_img" data-bind="visible: ava.length > 0, attr: { src : ava }"></a>
                                <div class="b-user-info_hold">
                                    <a class="b-user-info_name" data-bind="attr: { href : url }, text: fullName"></a>
                                    <div class="b-user-info_date" data-bind="text: $root.currentPhoto().date"></div>
                                </div>
                            </div>


                        </div>

                        <div class="photo-window_about"><span data-bind="text: properties.label"></span>&nbsp;&nbsp;&nbsp;<a data-bind="text: properties.title, attr: { href : properties.url }"></a> </div>

                        <div class="photo-window_t">
                            <!-- ko if: currentPhoto().isEditable && currentPhoto().titleBeingEdited() -->
                                <input type="text" class="itx-gray" placeholder="Введите название фото и нажмите Enter" data-bind="value: currentPhoto().titleValue, returnKey: currentPhoto().saveTitle, hasfocus: currentPhoto().titleBeingEdited()">
                            <!-- /ko -->
                            <!-- ko if: ! currentPhoto().titleBeingEdited() -->
                                <span data-bind="text: currentPhoto().title()"></span>
                                <!-- ko if: currentPhoto().isEditable -->
                                    <a class="ico-edit powertip" data-bind="click: currentPhoto().editTitle, tooltip: 'Редактировать'"></a>
                                <!-- /ko -->
                            <!-- /ko -->
                        </div>

                        <div class="photo-window_desc-hold ">
                            <!-- ko if: ! currentPhoto().descriptionBeingEdited() && currentPhoto().description().length > 0 -->
                                <div class="photo-window_desc clearfix">
                                    <p>
                                        <span data-bind="text: currentPhoto().description"></span>
                                        <!-- ko if: currentPhoto().isEditable -->
                                            <a class="ico-edit powertip" data-bind="click: currentPhoto().editDescription, tooltip: 'Редактировать'"></a>
                                        <!-- /ko -->
                                    </p>
                                </div>
                            <!-- /ko -->

                            <!-- ko if: currentPhoto().isEditable && currentPhoto().descriptionBeingEdited() -->
                                <textarea cols="15" rows="2" class="itx-gray" placeholder="Введите описание фото и нажмите Enter" data-bind="value: currentPhoto().descriptionValue, autogrow: true, returnKey: currentPhoto().saveDescription, valueUpdate: 'keyup', hasfocus: currentPhoto().descriptionBeingEdited() && ! currentPhoto().titleBeingEdited()"></textarea>
                            <!-- /ko -->
                        </div>

                        <div class="comments-gray comments-gray__small">
                            <div class="comments-gray_add active clearfix">

                                <!-- ko if: user !== null -->
                                <div class="comments-gray_ava" data-bind="with: user">
                                    <a class="ava ava__small" data-bind="attr: { href : url }, css: avaCssClass">
                                        <img alt="" class="ava_img" data-bind="visible: ava.length > 0, attr: { src : ava }">
                                    </a>
                                </div>
                                <!-- /ko -->

                                <div class="comments-gray_frame">
                                    <textarea cols="15" rows="2" class="itx-gray" placeholder="Введите ваш комментарий и нажмите Enter" data-bind="returnKey: addComment, valueUpdate: 'keyup', value: commentText"></textarea>
                                </div>
                            </div>
                            <div class="comments-gray_t">
                                <!-- ko if: currentPhoto().commentsCount() > 0 -->
                                <span class="comments-gray_t-tx">Комментарии <span class="color-gray" data-bind="text: '(' + currentPhoto().commentsCount() + ')'"></span></span>
                                <a class="font-small" id="comments-show" href="javascript:void(0)" onclick="location.reload()">Показать </a>
                                <!-- /ko -->
                                <!-- <a href="" class="float-r font-small">Статистика (14)</a> -->
                                <div class="comments-gray_sent">Комментарий успешно отправлен.</div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="scroll_bar-hold">
                    <div class="scroll_bar">
                        <div class="scroll_bar-in"></div>
                    </div>
                </div>
            </div>

            <div id="photo-window_banner" class="photo-window_banner clearfix">
                <iframe src="/google.html?<?=mt_rand(1000000000, 9999999999)?>" width="300" height="250" marginwidth="0" marginheight="0" scrolling="no" frameborder="0"></iframe>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
//    (function(bannerPlaceId, requestSrc, defaultLoad){
//        var
//            tgNS = window.ADFOX.RELOAD_CODE,
//            initData = tgNS.initBanner(bannerPlaceId,requestSrc);
//
//        $('#photo-window_banner').html(initData.html);
//
//        if(defaultLoad) {
//            tgNS.loadBanner(initData.pr1, requestSrc, initData.sessionId);
//        }
//    })('bn-1', 'http://ads.adfox.ru/211012/prepareCode?pp=dey&amp;ps=bkqy&amp;p2=etcx&amp;pct=a&amp;plp=a&amp;pli=a&amp;pop=a', true);

    photoViewVM = new PhotoCollectionViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(photoViewVM, document.getElementById('photo-window'));
</script>