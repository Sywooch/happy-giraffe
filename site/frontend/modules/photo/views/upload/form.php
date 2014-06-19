<div class="popup-container display-b">
    <div id="photo-computer-mylti-empty" class="popup popup-add popup-add__photos">
        <button title="Закрыть (Esc)" type="button" class="mfp-close">×</button>
        <div class="popup-add_hold">
            <div class="popup-add_top clearfix">
                <div class="popup-add_t">Добавить фотографии</div>
                <ul class="tabs-simple tabs-simple__inline nav nav-tabs">
                    <li class="active"><a href="#photo-tab-computer" data-toggle="tab">С компьютера</a></li>
                    <li><a href="#photo-tab-album" data-toggle="tab">Из моих альбомов</a></li>
                    <li><a href="#photo-tab-link" data-toggle="tab">Из интернета</a></li>
                </ul>
            </div>
            <div class="popup-add_in tab-content">
                <div id="photo-tab-computer" class="tab-pane active">
                    <!-- К .popup-add_frame__multi при перетаскивании добавить class.dragover-->
                    <div class="popup-add_frame popup-add_frame__multi dragover">
                        <div class="popup-add_cap">
                            <!-- Размер файла, необходимо указать программисту-->
                            <!-- cap-empty-->
                            <div class="cap-empty cap-empty__addPhoto">
                                <div class="cap-empty_hold">
                                    <div class="cap-empty_img"></div>
                                    <div class="cap-empty_t">Выберите файлы с компьютера</div>
                                    <div class="cap-empty_tx-sub"><div class='file-fake'><div class='btn btn-s btn-primary file-fake_btn'>Обзор</div><input type='file' class='file-fake_inp'></div>  <div class='popup-add_cap-desc'>Разрешенные форматы файлов JPG, GIF, PNG.<br> Максимальный размер 700 Kб.</div><div class='popup-add_cap-drag'>или перетащите фотографии сюда</div></div>
                                </div>
                                <div class="verticalalign-m-help"></div>
                            </div>
                            <!-- /cap-empty-->
                        </div>
                    </div>
                </div>
                <div id="photo-tab-album" class="tab-pane"></div>
                <div id="photo-tab-link" class="tab-pane"></div>
            </div>
        </div>
    </div>
</div>