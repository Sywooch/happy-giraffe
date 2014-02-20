<div class="popup-sign_top">
    <div class="popup-sign_t">Добро пожаловать, <span data-bind="text: first_name"></span>!</div>
    <div class="popup-sign_slogan">Осталось ввести еще немного данных</div>
</div>
<div class="popup-sign_cont">
    <div class="popup-sign_col-ava"><a href="" class="ava ava__large"><span class="ico-status"></span><img alt="" src="" class="ava_img"/></a>
        <div class="margin-5">
            <div class="popup-sign_tx-help">Чтобы вас узнавали на Веселом Жирафе <br> загрузите свое главное фото</div>
        </div><a class="btn-s btn-blue-simple">Загрузить</a>
    </div>
    <div class="popup-sign_col popup-sign_col__vetical-m">
        <div class="popup-sign_row">
            <div class="popup-sign_label">Местоположение</div>
        </div>
        <div class="popup-sign_row">
            <div class="inp-valid inp-valid__abs error">
                <select placeholder="Выбор страны" class="select-cus select-cus__search-on select-cus__gray">
                    <option></option>
                    <option value="2">Россия</option>
                    <option value="3">Беларусь</option>
                    <option value="4">Казахстан</option>
                </select>
                <div class="inp-valid_error">
                    <div class="errorMessage">Страна не вабрана</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
            <div class="popup-sign_tx-help">Начинайте вводить название страны...</div>
        </div>
        <div class="popup-sign_row">
            <div class="inp-valid inp-valid__abs">
                <select placeholder="Населенный пункт" class="select-cus select-cus__search-on select-cus__gray">
                    <option></option>
                    <option value="2">Россия</option>
                    <option value="3">Беларусь</option>
                    <option value="4">Казахстан</option>
                </select>
                <div class="inp-valid_error">
                    <div class="errorMessage">Не заполнено поле "Фамилия"</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
        </div>
        <div class="popup-sign_row">
            <div class="popup-sign_label">Дата рождения</div>
        </div>
        <div class="popup-sign_row">
            <div class="inp-valid inp-valid__abs success">
                <div class="float-l w-80 margin-r10">
                    <select placeholder="День" class="select-cus select-cus__search-off select-cus__gray">
                        <option></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="8">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="float-l w-135 margin-r10">
                    <select placeholder="День" class="select-cus select-cus__search-off select-cus__gray">
                        <option></option>
                        <option value="1">Января</option>
                        <option value="2">Февраля</option>
                        <option value="3">Марта</option>
                        <option value="4">Апреля</option>
                        <option value="5">Майя</option>
                        <option value="6">Июня</option>
                        <option value="7">Июля</option>
                        <option value="8">Августа</option>
                        <option value="9">Сентября</option>
                        <option value="10">Октября</option>
                        <option value="11">Ноября</option>
                        <option value="12">Декабря</option>
                    </select>
                </div>
                <div class="float-l w-80">
                    <select placeholder="Год" class="select-cus select-cus__search-off select-cus__gray">
                        <option></option>
                        <option value="1">1912</option>
                        <option value="2">1913</option>
                        <option value="3">1914</option>
                        <option value="4">1915</option>
                        <option value="5">1916</option>
                        <option value="6">1917</option>
                        <option value="7">1918</option>
                        <option value="8">1919</option>
                        <option value="8">1920</option>
                        <option value="10">1921</option>
                        <option value="11">1922</option>
                        <option value="12">1923</option>
                    </select>
                </div>
                <div class="inp-valid_error">
                    <div class="errorMessage">Не выбрана дата</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
            </div>
        </div>
        <div class="popup-sign_row margin-b30">
            <div class="popup-sign_label">
                <div class="display-ib">
                    <div class="inp-valid inp-valid__abs error">Пол
                        <div class="radio-icons radio-icons__inline margin-l20">
                            <input id="radio4" type="radio" name="b-radio2" class="radio-icons_radio">
                            <label for="radio4" class="radio-icons_label">Мужской</label>
                            <input id="radio3" type="radio" name="b-radio2" class="radio-icons_radio">
                            <label for="radio3" class="radio-icons_label">Женский</label>
                        </div>
                        <div class="inp-valid_error">
                            <div class="errorMessage">Выберите пол</div>
                        </div>
                        <div class="inp-valid_success inp-valid_success__ico-check"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-sign_row">
            <div class="popup-sign_label">Код</div>
        </div>
        <div class="popup-sign_row margin-b30">
            <div class="popup-sign_capcha-hold">
                <div class="margin-b3"><img src="/images/captcha.png" class="popup-sign_capcha">
                </div><a class="popup-sign_tx-help">
                    <div class="ico-refresh"></div>Обновить</a>
            </div>
            <div class="popup-sign_capcha-inp">
                <div class="inp-valid inp-valid__abs">
                    <input type="text" class="itx-gray popup-sign_itx">
                    <div class="inp-valid_error">
                        <div class="errorMessage">Неправильный код проверки</div>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
                <div class="popup-sign_tx-help">Введите код с картинки</div>
            </div>
        </div>
        <div class="popup-sign_row">
            <div class="btn-green-simple btn-l">Продолжить</div>
        </div>
    </div>
</div>