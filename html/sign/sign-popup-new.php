<!DOCTYPE html>
<html class="no-js">
  <head>
    <?php include $_SERVER['DOCUMENT_ROOT'].'/block/global/head.php'; ?>
  </head>
  <body class="body">
    <div class="layout-container">
      
      <div class="layout-wrapper">
        <div class="layout-wrapper_frame clearfix">
          <div class="layout-wrapper_hold clearfix">
            <div class="layout-content clearfix">
              <div class="margin-20">
                <h2>Регистрация</h2><a href="#reg-step1" class="popup-a">Регистрация шаг 1</a><br><br><a href="#reg-step2" class="popup-a">Регистрация шаг 2</a><br><br><a href="#reg-step2-soc" class="popup-a">Регистрация шаг 2 через социальные сети</a><br><br><a href="#reg-email" class="popup-a">Подтверждение email</a><br><br><a href="#reg-email2" class="popup-a">Отправка email повторно</a><br><br>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div onclick="$('html, body').animate({scrollTop:0}, 'normal')" class="btn-scrolltop"></div>
    </div>
    <div class="popup-container display-n"> 
      <!-- .popup-sign-->
      <div id="reg-step1" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_t">Регистрация на Веселом Жирафе</div>
            <div class="popup-sign_slogan">Стань полноправным участником сайта за 1 минуту!</div>
          </div>
          <div class="popup-sign_cont">
            <div class="popup-sign_social">
              <div class="popup-sign_row">
                <div class="popup-sign_label">С помощью социальных сетей</div>
              </div>
              <ul class="social-btns clearfix">
                <li><a class="social-btn social-btn__odnoklassniki"><span class="social-btn_ico"></span><span class="social-btn_tx">Одноклассники</span></a></li>
                <li><a class="social-btn social-btn__vkontakte"><span class="social-btn_ico"></span><span class="social-btn_tx">ВКонтакте</span></a></li>
              </ul>
            </div>
            <div class="popup-sign_col">
              <div class="popup-sign_row">
                <div class="popup-sign_label">Адрес активной электронной почты</div>
              </div>
              <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                  <input type="text" placeholder="E-mail" class="itx-gray popup-sign_itx">
                  <div class="inp-valid_error">
                    <div class="errorMessage">E-mail не является правильным E-Mail адресом</div>
                  </div>
                  <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
              </div>
              <div class="popup-sign_row">
                <div class="popup-sign_label">Полное имя</div>
              </div>
              <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                  <input type="text" placeholder="Имя" class="itx-gray popup-sign_itx">
                  <div class="inp-valid_error">
                    <div class="errorMessage">Не заполнено поле "Имя"</div>
                  </div>
                  <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
              </div>
              <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                  <input type="text" placeholder="Фамилия" class="itx-gray popup-sign_itx">
                  <div class="inp-valid_error">
                    <div class="errorMessage">Не заполнено поле "Фамилия"</div>
                  </div>
                  <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
              </div>
              <div class="popup-sign_row">
                <div class="btn-green-simple btn-l">Зарегистрироваться</div>
              </div>
              <div class="popup-sign_row">
                <div class="popup-sign_tx-help">Продолжая, вы соглашаетесь с нашими  <a class="a-color-gray-light">Условиями использования</a>,<a class="a-color-gray-light">Политикой конфиденциальности </a>и <a class="a-color-gray-light">Положениями о Cookie</a></div>
              </div>
            </div>
          </div>
          <div class="popup-sign_b"><span class="popup-sign_b-tx">Вы уже зарегистрированы?</span><a class="popup-sign_b-a">Войти</a></div>
        </div>
      </div>
      <!-- /popup-sign-->
      <!-- .popup-sign-->
      <div id="reg-step2" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_t">Добро пожаловать Александр!</div>
            <div class="popup-sign_slogan">Осталось ввести еще немного данных</div>
          </div>
          <div class="popup-sign_cont">
            <div class="popup-sign_col-ava"><a href="" class="ava ava__large"><img alt="" src="" class="ava_img"/></a>
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
        </div>
      </div>
      <!-- /popup-sign-->
      <!-- .popup-sign-->
      <div id="reg-step2-soc" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_t">Добро пожаловать Александр!</div>
            <div class="popup-sign_slogan">Осталось ввести еще немного данных</div>
          </div>
          <div class="popup-sign_cont">
            <div class="popup-sign_col-ava"><a href="" class="ava ava__large ava__female"><img alt="" src="/new/images/example/ava-large2.jpg" class="ava_img"/></a>
              <div class="margin-5">
                <div class="popup-sign_tx-help">Это фото будет главным на Веселом Жирафе</div>
              </div><a class="btn-s btn-blue-simple">Изменить</a>
            </div>
            <div class="popup-sign_col popup-sign_col__vetical-m">
              <div class="popup-sign_row">
                <div class="popup-sign_label">Адрес активной электронной почты</div>
              </div>
              <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                  <input type="text" placeholder="E-mail" value="weriwpoer" class="itx-gray popup-sign_itx">
                  <div class="inp-valid_error">
                    <div class="errorMessage">E-mail не является правильным E-Mail адресом</div>
                  </div>
                  <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
              </div>
              <div class="popup-sign_row">
                <div class="btn-green-simple btn-l">Продолжить</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /popup-sign-->
      <!-- .popup-sign-->
      <div id="reg-email" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_t">Добро пожаловать Александр! <br> Теперь вы с Веселым Жирафом!</div>
          </div>
          <div class="popup-sign_cont">
            <div class="popup-sign_tx margin-b40 margin-b70">Для завершения регистрации, <span class="i-highlight">нажмите на ссылку в письме,</span><br><span class="i-highlight">которое мы отправили вам на указанный вами e-mail  <span class="color-gray-dark-light">lepilla@mail.ru</span></span></div>
            <div class="popup-sign_col textalign-c margin-b70">
              <div class="display-ib textalign-l"><a class="popup-sign_a-m">Не получили письмо?</a>
                <div class="popup-sign_tx-help">Письмо должно прийти в течении 10 мин.</div>
              </div>
            </div>
            <div class="popup-sign_col-wide-r textalign-c"><a href="" target="_blank" class="popup-sign_a-big">Открыть почту Mail.ru</a></div>
          </div>
        </div>
      </div>
      <!-- /popup-sign-->
      <!-- .popup-sign-->
      <div id="reg-email2" class="popup popup-sign">
        <div class="popup-sign_hold">
          <div class="popup-sign_top">
            <div class="popup-sign_t">Добро пожаловать Александр! <br> Теперь вы с Веселым Жирафом!</div>
          </div>
          <div class="popup-sign_cont">
            <div class="popup-sign_col">
              <div class="popup-sign_row margin-t5">
                <div class="inp-valid inp-valid__abs success">
                  <input type="text" placeholder="E-mail" class="itx-gray popup-sign_itx">
                  <div class="inp-valid_error">
                    <div class="errorMessage">Не заполнено поле</div>
                  </div>
                  <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
                <div class="popup-sign_tx-help">Пожалуйста проверьте правильность указанного адреса электронной почты или введите другой</div>
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
                  <div class="inp-valid inp-valid__abs error">
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
                <div class="display-ib textalign-c">
                  <div class="btn-green-simple btn-l margin-b5">Отправить письмо еще раз</div>
                  <div class="popup-sign_tx-help">Письмо должно прийти в течении 10 мин.</div>
                </div>
              </div>
            </div>
            <div class="popup-sign_col-wide-r">
              <div class="margin-b15">Письмо может попасть в папку "Спам" вашего почтового ящика. Если это так, пожалуйста, отметьте его как <strong class="color-gray-darken">"Не спам"</strong>.</div><a href="" target="_blank" class="popup-sign_a-big">Открыть почту Mail.ru</a>
            </div>
          </div>
        </div>
      </div>
      <!-- /popup-sign-->
    </div>
  </body>
</html>