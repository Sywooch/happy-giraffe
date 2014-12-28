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
                
                <h2>Регистрация</h2><br><a href="#reg-step1" class="popup-a">Регистрация шаг 1</a><br><br><a href="#reg-step2" class="popup-a">Регистрация шаг 2</a><br><br><a href="#reg-step2-soc" class="popup-a">Регистрация шаг 2 через социальные сети</a><br><br><a href="#login-step1" class="popup-a">Логин</a><br><br><a href="#login-retrieve" class="popup-a">Восстановление пароля</a><br><br><a href="#login-retrieve2" class="popup-a">Восстановление пароля, письмо отправлено </a><br><br>
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
          <div class="popup-sign_t popup-sign_t__logo"> <span class="logo logo__xs"></span>Регистрация </div>
          <div class="popup-sign_top-btns"><span class="popup-sign_t-tx">Уже зарегистрированы?</span>
            <div class="btn btn-secondary btn-xm">Войти</div>
          </div>
        </div>
        <div class="popup-sign_cont">
          <div class="popup-sign_col popup-sign_col__left">
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs success">
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
                  <div class="errorMessage">
                     
                    Не заполнено поле "Фамилия"
                  </div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="popup-sign_label">Дата рождения</div>
            </div>
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs success">
                <div class="float-l w-80 margin-r5">
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
                <div class="float-l w-115 margin-r5">
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
                  <div class="errorMessage">
                     
                    Не выбрана дата
                  </div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="popup-sign_label"> 
                <div class="display-ib">
                  <div class="inp-valid inp-valid__abs error">Пол
                    <div class="radio-icons radio-icons__inline margin-l10">
                      <input id="radio4" type="radio" name="b-radio2" class="radio-icons_radio">
                      <label for="radio4" class="radio-icons_label">Мужской</label>
                      <input id="radio3" type="radio" name="b-radio2" class="radio-icons_radio">
                      <label for="radio3" class="radio-icons_label">Женский</label>
                    </div>
                    <div class="inp-valid_error">
                      <div class="errorMessage">
                         
                        Выберите пол
                      </div>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="popup-sign_row margin-t15">
              <div class="inp-valid inp-valid__abs">
                <input type="text" placeholder="Email" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error">
                  <div class="errorMessage">E-mail не является правильным E-Mail адресом</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs">
                <input type="text" placeholder="Пароль" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error">
                  <div class="errorMessage">Не возможный пароль</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="btn-xl btn btn-success btn-block disabled">Зарегистрироваться</div>
            </div>
          </div>
          <div class="popup-sign_social">
            <div class="popup-sign_row">
              <div class="popup-sign_label textalign-c">или быстро через</div>
            </div>
            <ul class="social-btns clearfix">
              <li class="auth-service odnoklassniki"><a class="social-btn social-btn__odnoklassniki"><span class="social-btn_ico"></span><span class="social-btn_tx">Одноклассники</span></a></li>
              <li class="auth-service vkontakte"><a class="social-btn social-btn__vkontakte"><span class="social-btn_ico"></span><span class="social-btn_tx">ВКонтакте</span></a></li>
            </ul>
          </div>
        </div>
        <div class="popup-sign_b">
          <div class="popup-sign_tx-help">Продолжая, вы соглашаетесь с нашими  <a class="a-gray">Условиями использования</a>, <a class="a-gray">Политикой конфиденциальности</a>
          </div>
        </div>
      </div>
    </div>
    <!-- /popup-sign-->
    <!-- .popup-sign-->
    <div id="reg-step2" class="popup popup-sign">
      <div class="popup-sign_hold">
        <div class="popup-sign_cont">
          <div class="popup-sign_capcha-hold">
            <div class="popup-sign_row">
              <div class="heading-xl">Введите слово с картинки</div>
            </div>
            <div class="popup-sign_col">
              <div class="popup-sign_row"><img src="/images/captcha.png" width="285" height="50" class="popup-sign_capcha">
                <div class="textalign-c"><a class="a-gray">
                    <div class="ico-refresh"></div>Показать другое слово</a></div>
              </div>
              <div class="popup-sign_row"> 
                <!--.popup-sign_capcha-inp-->
                <div class="inp-valid inp-valid__abs">
                  <input type="text" placeholder="Введите слово" class="itx-gray popup-sign_itx">
                  <div class="inp-valid_error">
                    <div class="errorMessage">Неправильный код проверки</div>
                  </div>
                  <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
              </div>
              <div class="popup-sign_row">
                <div class="btn-xl btn btn-success btn-block loading">Продолжить</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /popup-sign-->
    <!-- .popup-sign-->
    <div id="reg-step2-soc" class="popup popup-sign">
      <div class="popup-sign_hold">
        <div class="popup-sign_cont">
          <div class="popup-sign_col">
            <div class="popup-sign_row textalign-c">
              <!-- ava--><span href="#" class="ava ava__female"><img alt="" src="http://img.happy-giraffe.ru/avatars/12963/ava/8d26a6f4dbae0536f8dbec37c0b5e5f8.jpg" class="ava_img"></span>
            </div>
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs success">
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
                  <div class="errorMessage">
                     
                    Не заполнено поле "Фамилия"
                  </div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="popup-sign_label">Дата рождения</div>
            </div>
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs success">
                <div class="float-l w-80 margin-r5">
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
                <div class="float-l w-115 margin-r5">
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
                  <div class="errorMessage">
                     
                    Не выбрана дата
                  </div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="popup-sign_label"> 
                <div class="display-ib">
                  <div class="inp-valid inp-valid__abs error">Пол
                    <div class="radio-icons radio-icons__inline margin-l10">
                      <input id="radio4" type="radio" name="b-radio2" class="radio-icons_radio">
                      <label for="radio4" class="radio-icons_label">Мужской</label>
                      <input id="radio3" type="radio" name="b-radio2" class="radio-icons_radio">
                      <label for="radio3" class="radio-icons_label">Женский</label>
                    </div>
                    <div class="inp-valid_error">
                      <div class="errorMessage">
                         
                        Выберите пол
                      </div>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="popup-sign_row margin-t15">
              <div class="inp-valid inp-valid__abs">
                <input type="text" placeholder="Email" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error">
                  <div class="errorMessage">E-mail не является правильным E-Mail адресом</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs">
                <input type="text" placeholder="Пароль" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error">
                  <div class="errorMessage">Не возможный пароль</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="btn-xl btn btn-success btn-block">Зарегистрироваться</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /popup-sign-->
    
    
    <!-- .popup-sign-->
    <div id="login-step1" class="popup popup-sign">
      <div class="popup-sign_hold">
        <div class="popup-sign_top">
          <div class="popup-sign_t popup-sign_t__logo"> <span class="logo logo__xs"></span>Вход на сайт </div>
          <div class="popup-sign_top-btns"><span class="popup-sign_t-tx">Не зарегистрированы?</span>
            <div class="btn btn-secondary btn-xm">Регистрация</div>
          </div>
        </div>
        <div class="popup-sign_cont">
          <div class="popup-sign_col popup-sign_col__left">
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs">
                <input type="text" placeholder="Email" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error">
                  <div class="errorMessage">E-mail не является правильным E-Mail адресом</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="inp-valid inp-valid__abs">
                <input type="text" placeholder="Пароль" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error">
                  <div class="errorMessage">Не возможный пароль</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="float-r margin-t1"><a>Забыли пароль?</a></div>
              <div class="float-l">
                <div class="radio-icons radio-icons__checkbox">
                  <input id="checkboxid" type="checkbox" name="checkbox" class="radio-icons_radio">
                  <label for="checkboxid" class="radio-icons_label">Запомнить меня</label>
                </div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="btn-xl btn btn-success disabled">Войти на сайт</div>
            </div>
          </div>
          <div class="popup-sign_social">
            <div class="popup-sign_row">
              <div class="popup-sign_label textalign-c">или через</div>
            </div>
            <ul class="social-btns clearfix">
              <li class="auth-service odnoklassniki"><a class="social-btn social-btn__odnoklassniki"><span class="social-btn_ico"></span><span class="social-btn_tx">Одноклассники</span></a></li>
              <li class="auth-service vkontakte"><a class="social-btn social-btn__vkontakte"><span class="social-btn_ico"></span><span class="social-btn_tx">ВКонтакте</span></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- /popup-sign-->
    <!-- .popup-sign-->
    <!-- /popup-sign-->
    <!-- .popup-sign-->
    <div id="login-retrieve" class="popup popup-sign">
      <div class="popup-sign_hold">
        <div class="popup-sign_top">
          <div class="popup-sign_t"> <span class="ico-lock-big"></span>Напомнить пароль</div>
        </div>
        <div class="popup-sign_cont">
          <div class="popup-sign_tx">Пожалуйста введите ваш Email. Вам будет выслано письмо с вашим паролем.</div>
          <div class="popup-sign_col-w">
            <div class="popup-sign_row clearfix">
              <div class="inp-valid inp-valid__abs inp-valid__success">
                <input type="text" placeholder="E-mail" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error"> 
                  <div class="inp-valid_error-tx">E-mail не является правильным E-Mail адресом</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
            <div class="popup-sign_row">
              <div class="btn-xl btn btn-success">Отправить пароль</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /popup-sign-->
    <!-- .popup-sign-->
    <div id="login-retrieve2" class="popup popup-sign">
      <div class="popup-sign_hold">
        <div class="popup-sign_top">
          <div class="popup-sign_t"> <span class="ico-lock-big"></span>Напомнить пароль</div>
        </div>
        <div class="popup-sign_cont">
          <div class="i-info-success">Вам отправлено письмо с новым паролем.</div>
          <div class="popup-sign_tx">Пожалуйста введите ваш Email. Вам будет выслано письмо с вашим паролем.</div>
          <div class="popup-sign_col-w">
            <div class="popup-sign_row clearfix">
              <div class="inp-valid inp-valid__abs inp-valid__success">
                <input type="text" placeholder="E-mail" class="itx-gray popup-sign_itx">
                <div class="inp-valid_error"> 
                  <div class="inp-valid_error-tx">E-mail не является правильным E-Mail адресом</div>
                </div>
                <div class="inp-valid_success inp-valid_success__ico-check"></div>
              </div>
            </div>
          </div>
          <div class="popup-sign_row">
            <div class="btn-xl btn btn-success disabled">Отправить пароль</div>
          </div>
        </div>
      </div>
    </div>
    <!-- /popup-sign-->
    </div>
  </body>
</html>