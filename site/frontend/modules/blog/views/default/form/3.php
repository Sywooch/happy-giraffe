<div class="b-settings-blue b-settings-blue__photo">
    <div class="b-settings-blue_tale"></div>
    <div class="clearfix">

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Личные <br> фотоальбомы</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img1.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46" onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo').show();">Загрузить фото</a>
            </div>
        </div>

        <div class="b-settings-blue_photo-record">
            <div class="b-settings-blue_photo-record-t">Фотопост <br> в блоге</div>
            <div class="b-settings-blue_photo-record-img">
                <img src="/images/b-settings-blue_photo-record-img2.png" alt="" class="">
            </div>
            <div class="clearfix">
                <a href="javascript:;" class="btn-blue btn-h46" onclick="$(this).parents('.b-settings-blue').hide();$('#popup-user-add-photo-post').show();">Создать фотопост</a>
            </div>
        </div>

    </div>
</div>

<div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo-post" style="display: none;">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <div class="clearfix">
                <div class="float-r font-small color-gray margin-3">0/50</div>
            </div>
            <label for="" class="b-settings-blue_label">Заголовок</label>
            <input type="text" name="" id="" class="itx-simple w-400" placeholder="Введите заголовок видео">
        </div>
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Рубрика</label>
            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <select class="chzn chzn-done" id="selK3R" style="display: none;">
                        <option selected="selected">0</option>
                        <option>Россия</option>
                        <option>2</option>
                        <option>32</option>
                        <option>32</option>
                        <option>32</option>
                        <option>32</option>
                        <option>132</option>
                        <option>132</option>
                        <option>132</option>
                    </select><div id="selK3R_chzn" class="chzn-container chzn-container-single" style="width: 2px;"><a href="javascript:void(0)" class="chzn-single" tabindex="-1"><span>0</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 2px; top: 0px;"><div class="chzn-search" style=""><input type="text" autocomplete="off" style=""></div><ul class="chzn-results"><li id="selK3R_chzn_o_0" class="active-result result-selected" style="">0</li><li id="selK3R_chzn_o_1" class="active-result" style="">Россия</li><li id="selK3R_chzn_o_2" class="active-result" style="">2</li><li id="selK3R_chzn_o_3" class="active-result" style="">32</li><li id="selK3R_chzn_o_4" class="active-result" style="">32</li><li id="selK3R_chzn_o_5" class="active-result" style="">32</li><li id="selK3R_chzn_o_6" class="active-result" style="">32</li><li id="selK3R_chzn_o_7" class="active-result" style="">132</li><li id="selK3R_chzn_o_8" class="active-result" style="">132</li><li id="selK3R_chzn_o_9" class="active-result" style="">132</li></ul></div></div>
                    <div class="chzn-itx-simple_add">
                        <div class="chzn-itx-simple_add-hold">
                            <input type="text" name="" id="" class="chzn-itx-simple_add-itx">
                            <a href="" class="chzn-itx-simple_add-del" onclick="$.fancybox.close();return false;"></a>
                        </div>
                        <button class="btn-green">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- .dragover - класс добавлять, когда курсер мыши с файлами находится над блоком -->
    <div class="b-add-img b-add-img__for-multi">
        <div class="b-add-img_hold">
            <div class="b-add-img_t">
                Загрузите фотографии с компьютера
                <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
            </div>
            <div class="file-fake">
                <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                <input type="file" class="js-upload-files-multiple" multiple/>
            </div>
        </div>

        <div class="textalign-c clearfix">
            <!-- ko with: upload -->
            <!-- ko foreach: photos -->
            <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo' + uid}">
                <div class="b-add-img_i-vert"></div>
                <div class="b-add-img_i-load">
                    <div class="b-add-img_i-load-progress" data-bind="css: {width: progress}"></div>
                </div>
                <div class="b-add-img_i-overlay">
                    <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
                </div>
            </div>
            <!-- /ko -->
            <!-- /ko -->
        </div>

        <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
    </div>

    <div class="b-settings-blue_row clearfix">
        <textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш текст к фотопосту "></textarea>
    </div>
    <div class=" clearfix">
        <a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
        <a href="" class="btn-gray-light btn-h46 float-r margin-r15" onclick="$.fancybox.close();return false;">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">
                <div class="privacy-select_hold clearfix">
                    <div class="privacy-select_tx">Для кого:</div>
                    <div class="privacy-select_drop-hold">
                        <a href="" class="privacy-select_a">
                            <span class="ico-users ico-users__friend active"></span>
                            <span class="privacy-select_a-tx">только <br>друзьям</span>
                        </a>
                    </div>
                    <div class="privacy-select_drop">
                        <div class="privacy-select_i">
                            <a href="" class="privacy-select_a">
                                <span class="ico-users ico-users__all"></span>
                                <span class="privacy-select_a-tx">для <br>всех</span>
                            </a>
                        </div>
                        <div class="privacy-select_i">
                            <a href="" class="privacy-select_a">
                                <span class="ico-users ico-users__friend"></span>
                                <span class="privacy-select_a-tx">только <br>друзьям</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="b-settings-blue b-settings-blue__photo" id="popup-user-add-photo" style="display: none;">
    <div class="b-settings-blue_tale"></div>
    <div class="b-settings-blue_head">
        <div class="b-settings-blue_row clearfix">
            <label for="" class="b-settings-blue_label">Фотоальбом</label>
            <div class="w-400 float-l">
                <div class="chzn-itx-simple">
                    <select class="chzn chzn-done" id="selY9Q" style="display: none;">
                        <option selected="selected">0</option>
                        <option>Россия</option>
                        <option>2</option>
                        <option>32</option>
                        <option>32</option>
                        <option>32</option>
                        <option>32</option>
                        <option>132</option>
                        <option>132</option>
                        <option>132</option>
                    </select><div id="selY9Q_chzn" class="chzn-container chzn-container-single" style="width: 2px;"><a href="javascript:void(0)" class="chzn-single" tabindex="-1"><span>0</span><div><b></b></div></a><div class="chzn-drop" style="left: -9000px; width: 2px; top: 0px;"><div class="chzn-search" style=""><input type="text" autocomplete="off" style=""></div><ul class="chzn-results"><li id="selY9Q_chzn_o_0" class="active-result result-selected" style="">0</li><li id="selY9Q_chzn_o_1" class="active-result" style="">Россия</li><li id="selY9Q_chzn_o_2" class="active-result" style="">2</li><li id="selY9Q_chzn_o_3" class="active-result" style="">32</li><li id="selY9Q_chzn_o_4" class="active-result" style="">32</li><li id="selY9Q_chzn_o_5" class="active-result" style="">32</li><li id="selY9Q_chzn_o_6" class="active-result" style="">32</li><li id="selY9Q_chzn_o_7" class="active-result" style="">132</li><li id="selY9Q_chzn_o_8" class="active-result" style="">132</li><li id="selY9Q_chzn_o_9" class="active-result" style="">132</li></ul></div></div>
                    <div class="chzn-itx-simple_add">
                        <div class="chzn-itx-simple_add-hold">
                            <input type="text" name="" id="" class="chzn-itx-simple_add-itx">
                            <a href="" class="chzn-itx-simple_add-del"></a>
                        </div>
                        <button class="btn-green">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="b-add-img b-add-img__multi">
        <div class="b-add-img_hold">
            <div class="b-add-img_t">
                Загрузите фотографии с компьютера
                <div class="b-add-img_t-tx">Поддерживаемые форматы: jpg и png</div>
            </div>
            <div class="file-fake">
                <button class="btn-green btn-medium file-fake_btn">Обзор</button>
                <input type="file" class="js-upload-files-multiple" multiple />
            </div>
        </div>
        <div class="textalign-c clearfix">
            <!-- ko with: upload -->
            <!-- ko foreach: photos -->
            <div class="b-add-img_i" data-bind="attr: {id: 'uploaded_photo_' + uid}">
                <div class="b-add-img_i-vert"></div>
                <div class="b-add-img_i-load">
                    <div class="b-add-img_i-load-progress" data-bind="css: {width: progress}"></div>
                </div>
                <div class="b-add-img_i-overlay">
                    <a href="" class="b-add-img_i-del ico-close4" data-bind="click: remove"></a>
                </div>
            </div>
            <!-- /ko -->
            <!-- /ko -->
        </div>
        <!-- Текст приглашения для перетаскивания можно скрыть или удалить при наличии фото -->
        <div class="b-add-img_html5-tx">или перетащите фото сюда</div>
    </div>

    <div class=" clearfix">
        <a href="" class="btn-blue btn-h46 float-r">Добавить</a>
        <a href="" class="btn-gray-light btn-h46 float-r margin-r15">Отменить</a>

        <div class="float-l">
            <div class="privacy-select clearfix">
                <div class="privacy-select_hold clearfix">
                    <div class="privacy-select_tx">Для кого:</div>
                    <div class="privacy-select_drop-hold">
                        <a href="" class="privacy-select_a">
                            <span class="ico-users ico-users__friend active"></span>
                            <span class="privacy-select_a-tx">только <br>друзьям</span>
                        </a>
                    </div>
                    <div class="privacy-select_drop display-b">
                        <div class="privacy-select_i">
                            <a href="" class="privacy-select_a">
                                <span class="ico-users ico-users__all"></span>
                                <span class="privacy-select_a-tx">для <br>всех</span>
                            </a>
                        </div>
                        <div class="privacy-select_i">
                            <a href="" class="privacy-select_a">
                                <span class="ico-users ico-users__friend"></span>
                                <span class="privacy-select_a-tx">только <br>друзьям</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(function() {
        var PhotoPostViewModel = function() {
            var self = this;
            self.upload = ko.observable(new UploadPhotos());
            self.title = ko.observable('');
            self.text = ko.observable('');
        };
        var formVM1 = new PhotoPostViewModel();
        ko.applyBindings(formVM1, document.getElementById('popup-user-add-photo-post'));

        var PhotoAlbumViewModel = function() {
            var self = this;
            self.upload = ko.observable(new UploadPhotos());
        };
        var formVM2 = new PhotoAlbumViewModel();
        ko.applyBindings(formVM2, document.getElementById('popup-user-add-photo'));


        if (!(FileAPI.support.cors || FileAPI.support.flash)) {
            $('#oooops').show();
            $('#buttons-panel').hide();
        }

        if (FileAPI.support.dnd) {
            $('.b-add-img_html5-tx').show();

            $(document).dnd(function (over) {
            }, function (files) {
                formVM1.upload().onFiles(files);
                formVM2.upload().onFiles(files);
            });
        }

        $('#popup-user-add-photo .js-upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            formVM2.upload().onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });
        $('#popup-user-add-photo-post .js-upload-files-multiple').on('change', function (evt) {
            var files = FileAPI.getFiles(evt);
            formVM1.upload().onFiles(files);
            FileAPI.reset(evt.currentTarget);
        });
    });
</script>