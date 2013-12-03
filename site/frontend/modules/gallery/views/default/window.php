<div class="photo-window" id="photo-window">
    <div class="photo-window_w">
        <a class="photo-window_close" data-bind="click: close"></a>

        <div class="photo-window_top">
            <div class="photo-window_count" data-bind="text: currentNaturalIndex() + ' фото из ' + count"></div>
            <div class="photo-window_about"><span data-bind="text: properties.label"></span>&nbsp;&nbsp;&nbsp;<a data-bind="text: properties.title, attr: { href : properties.url }"></a> </div>

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
                        <?php $this->widget('FavouriteWidget', array('model' => $collection->rootModel, 'applyBindings' => false)); ?>
                    <!-- /ko -->
                <!-- /ko -->
            </div>
        </div>



        <div class="photo-window_col">

            <div class="photo-window_col-hold scroll">
                <div class="scroll_scroller  photo-window_cont">
                    <div class="scroll_cont">
                        <div class="photo-window_cont-t clearfix">
                            <div class="meta-gray">
                                <a class="meta-gray_comment" href="">
                                    <span class="ico-comment ico-comment__gray"></span>
                                    <span class="meta-gray_tx">35456</span>
                                </a>
                                <div class="meta-gray_view">
                                    <span class="ico-view ico-view__gray"></span>
                                    <span class="meta-gray_tx">305</span>
                                </div>
                            </div>
                            <div class="b-user-info b-user-info__middle float-l" data-bind="with: currentPhoto().user">
                                <a class="ava middle" data-bind="attr: { href : url }, css: avaCssClass"><img data-bind="visible: ava.length > 0, attr: { src : ava }"></a>
                                <div class="b-user-info_hold">
                                    <a class="b-user-info_name" data-bind="attr: { href : url }, text: fullName"></a>
                                    <div class="b-user-info_date" data-bind="text: $root.currentPhoto().date"></div>
                                </div>
                            </div>


                        </div>

                        <div class="photo-window_t">
                            <!-- ko if: currentPhoto().isEditable && currentPhoto().titleBeingEdited() -->
                                <input type="text" class="itx-gray" placeholder="Введите название фото и нажмите Enter" data-bind="value: currentPhoto().titleValue, returnKey: currentPhoto().saveTitle, hasfocus: currentPhoto().titleBeingEdited()">
                            <!-- /ko -->
                            <!-- ko if: ! currentPhoto().titleBeingEdited() -->
                                <span data-bind="text: currentPhoto().title()"></span>
                                <a class="ico-edit powertip" data-bind="click: currentPhoto().editTitle, tooltip: 'Редактировать'"></a>
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
                                <div class="wysiwyg-h">
                                    <textarea class="wysiwyg-redactor" placeholder="Введите описание фото и нажмите Enter" data-bind="value: currentPhoto().descriptionValue, autogrow: true, returnKey: currentPhoto().saveDescription, valueUpdate: 'keyup', hasfocus: currentPhoto().descriptionBeingEdited()"></textarea>
                                </div>
                            <!-- /ko -->
                        </div>

                        <div class="comments-gray comments-gray__small">
                            <div class="comments-gray_t">
                                <span class="comments-gray_t-tx">Комментарии <span class="color-gray">(28)</span></span>
                                <a href="" class="font-small" id="comments-show">Показать </a>
                                <!-- <a href="" class="float-r font-small">Статистика (14)</a> -->
                                <div class="comments-gray_sent display-b">Комментарий успешно отправлен.</div>
                            </div>
                            <div class="comments-gray_add active clearfix">

                                <div class="comments-gray_ava">
                                    <a href="" class="ava small female">
                                        <img src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" alt="">
                                    </a>
                                </div>

                                <div class="comments-gray_frame">
                                    <!-- input hidden -->
                                    <input type="text" name="" id="" class="comments-gray_add-itx itx-gray display-n" placeholder="Ваш комментарий">

                                    <script>
                                        $(document).ready(function () {
                                            $('.wysiwyg-redactor').redactor({
                                                autoresize: true,
                                                minHeight: 36,
                                                maxHeight: 0,
                                                toolbarExternal: '.wysiwyg-toolbar-btn',
                                                buttons: []
                                            });
                                        });
                                    </script>
                                    <div class="wysiwyg-h">
                                        <div class="wysiwyg-toolbar-btn"></div>
                                        <textarea name="" class="wysiwyg-redactor" placeholder="Введите ваш комментарий и нажмите Enter"></textarea>
                                    </div>
                                </div>
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
                <img src="/images/example/w300-h250.jpg" alt="">
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    photoViewVM = new PhotoCollectionViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(photoViewVM, document.getElementById('photo-window'));
</script>