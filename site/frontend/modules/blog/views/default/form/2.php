<div id="popup-user-add-video" class="popup-user-add-record">
    <a class="popup-transparent-close powertip" onclick="$.fancybox.close();" href="javascript:void(0);" title="Закрыть"></a>
    <div class="clearfix">
        <div class="w-720 float-r">

            <div class="user-add-record user-add-record__yellow clearfix">
                <div class="user-add-record_ava-hold">
                    <a href="" class="ava male">
                        <span class="icon-status status-online"></span>
                        <img alt="" src="http://img.happy-giraffe.ru/avatars/10/ava/f4e804935991c0792e91c174e83f3877.jpg">
                    </a>
                </div>
                <div class="user-add-record_hold">
                    <div class="user-add-record_tx">Я хочу добавить</div>
                    <a href="#popup-user-add-article" class="user-add-record_ico user-add-record_ico__article fancy">Статью</a>
                    <a href="#popup-user-add-photo" class="user-add-record_ico user-add-record_ico__photo fancy">Фото</a>
                    <a href="#popup-user-add-video" class="user-add-record_ico user-add-record_ico__video active fancy">Видео</a>
                </div>
            </div>

            <div class="b-settings-blue b-settings-blue__video">
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
                                <select class="chzn">
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
                                </select>
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
                <div class="b-settings-blue_add-video clearfix">
                    <!-- При вводе текста убрать класс .btn-inactive с кнопки для ее активирования -->
                    <input type="text" name="" id="" class="itx-simple w-400 float-l" placeholder="Введите ссылку на видео">
                    <button class="btn-green btn-inactive">Загрузить  видео</button>
                </div>
                <div class="b-settings-blue_video clearfix">
                    <a href="" class="b-settings-blue_video-del ico-close2 powertip" title="Удалить"></a>
                    <iframe width="580" height="320" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/pehSAUTqjRs?wmode=transparent"></iframe>
                </div>
                <div class="b-settings-blue_row clearfix">
                    <textarea name="" id="" cols="80" rows="5" class="b-settings-blue_textarea itx-simple" placeholder="Ваш комментарий"></textarea>
                </div>
                <div class=" clearfix">
                    <a href="" class="btn-blue btn-h46 float-r btn-inactive">Добавить</a>
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
        </div>
    </div>
</div>

<script>
    var BlogFormVideoViewModel = function() {
        var self = this;
        ko.utils.extend(self, new BlogFormViewModel());
    }

    formVM = new BlogFormPostViewModel();
    ko.applyBindings(formVM, document.getElementById('popup-user-add-article'));
</script>