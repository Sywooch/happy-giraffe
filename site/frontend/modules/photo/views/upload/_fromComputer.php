<div id="photo-tab-computer" class="tab-pane active">
    <div class="popup-add_frame popup-add_frame__multi" data-bind="visible: photos().length == 0">
        <div class="popup-add_cap">
            <div class="cap-empty cap-empty__addPhoto">
                <div class="cap-empty_hold">
                    <div class="cap-empty_img"></div>
                    <div class="cap-empty_t">Выберите файлы с компьютера</div>
                    <div class="cap-empty_tx-sub"><div class='file-fake'><div class='btn btn-s btn-primary file-fake_btn'>Обзор</div><input type='file' class='file-fake_inp' data-bind="fileUpload: fileUploadSettings"></div>  <div class='popup-add_cap-desc'>Разрешенные форматы файлов JPG, GIF, PNG.<br> Максимальный размер 700 Kб.</div><div class='popup-add_cap-drag'>или перетащите фотографии сюда</div></div>
                </div>
                <div class="verticalalign-m-help"></div>
            </div>
        </div>
    </div>

    <div class="popup-add_scroll scroll" data-bind="visible: photos().length > 0">
        <div class="popup-add_frame popup-add_frame__multi">
            <div class="scroll_scroller">
                <ul class="popup-add_multi scroll_cont">
                    <li class="popup-add_multi-li">
                        <!-- Блок фотографии Разные состояния блока применяются модификаторы .i-photo__load  .i-photo__error
                        -->
                        <div class="i-photo i-photo__load"><a href="" class="ico-close5"></a>
                            <!-- Разные состоянияния блока могут лежать в разных .i-photo_hold можно и управлять видами через их видимость-->
                            <!-- Загрузка фото-->
                            <div class="i-photo_hold">
                                <div class="i-photo_progress">
                                    <!-- boostrap progressbar-->
                                    <!-- progressbar изначально уже весь заполнен-->
                                    <div class="progress progress-striped active progress__cont">
                                        <div role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" class="progress-bar progress-bar__cont"></div>
                                    </div>
                                    <div class="tx-hint">Загрузка</div>
                                </div>
                            </div>
                        </div>
                        <!-- /Блок фотографии-->
                    </li>
                </ul>
            </div>
            <div class="scroll_bar-hold">
                <div class="scroll_bar">
                    <div class="scroll_bar-in"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    uploadVM = new PhotoUploadViewModel();
    ko.applyBindings(uploadVM, document.getElementById('photo-tab-computer'));
</script>