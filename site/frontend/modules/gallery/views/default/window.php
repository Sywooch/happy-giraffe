<div class="photo-window" id="photo-window">
    <div class="photo-window_w">
        <a href="javascript:void(0)" class="photo-window_close" data-bind="click: close"></a>

        <div class="photo-window_top">
            <div class="photo-window_count" data-bind="text: currentNaturalIndex() + ' фото из ' + count"></div>
            <div class="photo-window_about"><span data-bind="text: properties.label"></span>&nbsp;&nbsp;&nbsp;<a data-bind="text: properties.title, attr: { href : properties.url }"></a> </div>

        </div>
        <!-- Обрабатывать клик на .photo-window_c для листания следующего изображения -->
        <div class="photo-window_c">
            <div class="photo-window_img-hold">
                <img src="/images/example/w960-h537-1.jpg" alt="" class="photo-window_img">
                <div class="verticalalign-m-help"></div>
            </div>
            <a href="#photo-window-end" class="photo-window_arrow photo-window_arrow__l fancy" data-theme="white-simple"></a>
            <a href="#photo-window-end" class="photo-window_arrow photo-window_arrow__r fancy" data-theme="white-simple"></a>

            <div class="like-control clearfix">
                <a href="" class="like-control_ico like-control_ico__like">865</a>
                <div class="position-rel float-l">
                    <a class="favorites-control_a" href="">12365</a>
                    <!-- <div class="favorites-add-popup favorites-add-popup__right">
                        <div class="favorites-add-popup_t">Добавить запись в избранное</div>
                        <div class="favorites-add-popup_i clearfix">
                            <img src="/images/example/w60-h40.jpg" alt="" class="favorites-add-popup_i-img">
                            <div class="favorites-add-popup_i-hold">Неравный брак. Смертельно опасен или жизненно необходим?</div>
                        </div>
                        <div class="favorites-add-popup_row">
                            <label for="" class="favorites-add-popup_label">Теги:</label>
                            <span class="favorites-add-popup_tag">
                                <a href="" class="favorites-add-popup_tag-a">отношения</a>
                                <a href="" class="ico-close"></a>
                            </span>
                            <span class="favorites-add-popup_tag">
                                <a href="" class="favorites-add-popup_tag-a">любовь</a>
                                <a href="" class="ico-close"></a>
                            </span>
                        </div>
                        <div class="favorites-add-popup_row margin-b10">
                            <a class="textdec-none" href="">
                                <span class="ico-plus2 margin-r5"></span>
                                <span class="a-pseudo-gray color-gray">Добавить тег</span>
                            </a>
                        </div>
                        <div class="favorites-add-popup_row">
                            <label for="" class="favorites-add-popup_label">Комментарий:</label>
                            <div class="float-r color-gray">0/150</div>
                        </div>
                        <div class="favorites-add-popup_row">
                            <textarea name="" id="" cols="25" rows="2" class="favorites-add-popup_textarea" placeholder="Введите комментарий"></textarea>
                        </div>
                        <div class="favorites-add-popup_row textalign-c margin-t10">
                            <a href="" class="btn-gray-light">Отменить</a>
                            <a href="" class="btn-green">Добавить</a>
                        </div>
                    </div> -->
                </div>
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
                            <div class="b-user-info b-user-info__middle float-l">
                                <a href="" class="ava middle female"></a>
                                <div class="b-user-info_hold">
                                    <a href="" class="b-user-info_name">Ангелина Богоявленская</a>
                                    <div class="b-user-info_date">16 июн 2013</div>
                                </div>
                            </div>


                        </div>
                        <div class="photo-window_t">
                            <input type="text" name="" id="" class="itx-gray" placeholder="Введите название фото и нажмите Enter">
                            <!-- Детский лагерь «Зеркальный». Ленинградская область. Ghfg Ленинградская <a class="ico-edit powertip" href=""></a> -->
                        </div>

                        <div class="photo-window_desc-hold ">
                            <div class="photo-window_desc clearfix">
                                <p>В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, спокойные игры  В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, эстафеты, соревнования В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, эстафеты и спокойные игры.  <a class="ico-edit powertip" href=""></a></p>
                                <!-- <span class="photo-window_desc-more"> <a href="javascript:void(0)" >Кратко</a></span> -->
                            </div>

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