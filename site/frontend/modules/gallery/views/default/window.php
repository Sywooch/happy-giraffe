<div class="photo-window" id="photo-window">
    <div class="photo-window_w">
        <div class="photo-window_top clearfix">
            <a href="javascript:void(0)" class="photo-window_close" onclick="PhotoCollectionViewWidget.close()"></a>
            <div class="b-user-small float-l">
                <a class="ava small" data-bind="attr: { href : currentPhoto().user.url }, css: currentPhoto().user.avaCssClass"><img data-bind="visible: currentPhoto().user.ava.length > 0, attr: { src : currentPhoto().user.ava }"></a>
                <div class="b-user-small_hold">
                    <a class="b-user-small_name" data-bind="html: currentPhoto().user.firstName + ' <br>' + currentPhoto().user.lastName, attr: { href : currentPhoto().user.url }"></a>
                    <div class="b-user-small_date" data-bind="text: currentPhoto().date"></div>
                </div>
            </div>
            <div class="photo-window_top-hold">
                <div class="photo-window_count">25 фото из 52</div>
                <div class="photo-window_t" data-bind="text: currentPhoto().title"></div>
            </div>

        </div>
        <!-- Обрабатывать клик на юphoto-window_c для листания следующего изображения -->
        <div class="photo-window_c">
            <div class="photo-window_img-hold">
                <img alt="" class="photo-window_img" data-bind="attr: { src : currentPhoto().src }">
                <div class="verticalalign-m-help"></div>
            </div>
            <a class="photo-window_arrow photo-window_arrow__l" data-theme="white-simple" data-bind="click: prevHandler"></a>
            <a class="photo-window_arrow photo-window_arrow__r" data-theme="white-simple" data-bind="click: nextHandler"></a>


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

        <div class="photo-window_bottom">
            <script type="text/javascript">
            $(document).ready(function () {
                $('.photo-window_bottom').click(function(){
                    $(this).toggleClass('active');
                });
            });
            </script>
            <div class="photo-window_desc">
                <p>В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, спокойные игры <span class="photo-window_desc-more"> ... <a href="javascript:void(0)" >Читать полностью</a> <br></span> В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, эстафеты, соревнования</p>
                <p>В круглогодичном лечебно-развлекательном лагере «Зеркальный» ежедневно проводятся разнообразные мероприятия и программы - тематические, творческие и интеллектуальные конкурсы, концерты, викторины, активные и спокойные игры, эстафеты и спокойные игры.  <a href="javascript:void(0)" class="">Кратко</a> </p>
            </div>
        </div>

        <div class="photo-window_right">

            <div class="photo-window_banner-hold clearfix">
                <img src="/images/example/w300-h250.jpg" alt="">
            </div>
            <div class="comments-gray">
                <div class="comments-gray_t">
                    <span class="comments-gray_t-a-tx">Все комментарии (28)</span>
                </div>
                <div class="comments-gray_hold">
                    <div class="comments-gray_i comments-gray_i__self">
                        <div class="comments-gray_ava">
                            <a href="" class="ava small male"></a>
                        </div>
                        <div class="comments-gray_frame">
                            <div class="comments-gray_header clearfix">
                                <a href="" class="comments-gray_author">Ангелина Богоявленская </a>
                                <span class="font-smallest color-gray">Сегодня 13:25</span>
                            </div>
                            <div class="comments-gray_cont wysiwyg-content">
                                <p>	Мне безумно жалко всех женщин, но особенно Тину Кароль, я просто представить себе не могу <a href="">как она все это переживет</a> как она все это переживет(</p>
                                <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                            </div>
                        </div>
                        <div class="comments-gray_control comments-gray_control__self">
                            <div class="comments-gray_control-hold">
                                <div class="clearfix">
                                    <a href="" class="message-ico message-ico__edit powertip" title="Редактировать"></a>
                                </div>
                                <div class="clearfix">
                                    <a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comments-gray_i">
                        <a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
                        <div class="comments-gray_ava">
                            <a href="" class="ava small female"></a>
                        </div>
                        <div class="comments-gray_frame">
                            <div class="comments-gray_header clearfix">
                                <a href="" class="comments-gray_author">Анг Богоявлен </a>
                                <span class="font-smallest color-gray">Сегодня 14:25</span>
                            </div>
                            <div class="comments-gray_cont wysiwyg-content">
                                <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                            </div>
                        </div>

                        <div class="comments-gray_control">
                            <div class="comments-gray_control-hold">
                                <div class="clearfix">
                                    <a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
                                </div>
                                <div class="clearfix">
                                    <a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
                                </div>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
                            </div>
                        </div>
                    </div>
                    <div class="comments-gray_i">
                        <a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">7918</a>
                        <div class="comments-gray_ava">
                            <a href="" class="ava small female"></a>
                        </div>
                        <div class="comments-gray_frame">
                            <div class="comments-gray_header clearfix">
                                <a href="" class="comments-gray_author">Анг Богоявлен </a>
                                <span class="font-smallest color-gray">Сегодня 14:25</span>
                            </div>
                            <div class="comments-gray_cont wysiwyg-content">
                                <p>я не нашел, где можно поменять название трека. </p>
                            </div>
                        </div>

                        <div class="comments-gray_control">
                            <div class="comments-gray_control-hold">
                                <div class="clearfix">
                                    <a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
                                </div>
                                <div class="clearfix">
                                    <a href="" class="message-ico message-ico__del powertip" title="Удалить"></a>
                                </div>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
                            </div>
                        </div>
                    </div>

                    <div class="comments-gray_i comments-gray_i__recovery">
                        <div class="comments-gray_ava">
                            <a href="" class="ava small female"></a>
                        </div>
                        <div class="comments-gray_frame">
                            <div class="comments-gray_header clearfix">
                                <a href="" class="comments-gray_author">Анг Богоявлен </a>
                                <span class="font-smallest color-gray">Сегодня 14:25</span>
                            </div>
                            <div class="comments-gray_cont wysiwyg-content">
                                <p>Комментарий успешно удален.<a href="" class="comments-gray_a-recovery">Восстановить?</a> </p>
                            </div>
                        </div>
                    </div>

                    <div class="comments-gray_i">
                        <a href="" class="comments-gray_like like-hg-small powertip" title="Нравится">78</a>
                        <div class="comments-gray_ava">
                            <a href="" class="ava small female"></a>
                        </div>
                        <div class="comments-gray_frame">
                            <div class="comments-gray_header clearfix">
                                <a href="" class="comments-gray_author">Анг Богоявлен </a>
                                <span class="font-smallest color-gray">Сегодня 14:25</span>
                            </div>
                            <div class="comments-gray_cont wysiwyg-content">
                                <p>я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически производит поиск по сайту </p>
                                <p>и подцепляет естественно студийные версии песен вместо нужных.  я не нашел, где можно поменять название трека. Меняя название трека в альбоме он автоматически </p>
                            </div>
                        </div>

                        <div class="comments-gray_control">
                            <div class="comments-gray_control-hold">
                                <div class="clearfix">
                                    <a href="" class="comments-gray_quote-ico powertip" title="Ответить"></a>
                                </div>
                            </div>
                            <div class="clearfix">
                                <a href="" class="message-ico message-ico__warning powertip" title="Пожаловаться"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="photo-window_right-bottom">
            <div class="comments-gray comments-gray__photo-add">
                <div class="comments-gray_add clearfix">

                    <div class="comments-gray_ava">
                        <a href="" class="ava small female"></a>
                    </div>
                    <div class="comments-gray_frame">
                        <input type="text" name="" id="" class="comments-gray_add-itx itx-gray" placeholder="Ваш комментарий">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    photoViewVM = new PhotoCollectionViewModel(<?=CJSON::encode($json)?>);
    ko.applyBindings(photoViewVM, document.getElementById('photo-window'));
</script>