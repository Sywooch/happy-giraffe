<?php
/**
 * @var CActiveForm $form
 * @var User $model
 */
?>
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
        <div class="popup-sign_attr" data-bind="if: currentStep() == STEP_REG2 && email().length == 0">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Адрес активной электронной почты</div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                    <?=$form->textField($model, 'email', array(
                        'class' => 'itx-gray popup-sign_itx',
                        'placeholder' => 'E-mail',
                    ))?>
                    <div class="inp-valid_error">
                        <div class="errorMessage">E-mail не является правильным E-Mail адресом</div>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
            </div>
        </div>
        <div class="popup-sign_attr">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Местоположение</div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
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
        </div>
        <div class="popup-sign_attr">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Дата рождения</div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                    <div class="float-l w-80 margin-r10">
                        <?=$form->dropDownList($model, 'birthday_day', array(), array(
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_day, options: daysRange, optionsCaption: "День", selectize: {}',
                        ))?>
                    </div>
                    <div class="float-l w-135 margin-r10">
                        <?=$form->dropDownList($model, 'birthday_month', array_combine(range(1, 12), array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря')), array(
                            'placeholder' => 'Месяц',
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_month, options: monthesRange, optionsCaption: "Месяц", optionsText: "name", optionsValue: "id", selectize: {}',
                        ))?>
                    </div>
                    <div class="float-l w-80">
                        <?=$form->dropDownList($model, 'birthday_year', array_combine(range(date('Y') - 16, date('Y') - 90), range(date('Y') - 16, date('Y') - 90)), array(
                            'placeholder' => 'Год',
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_year, options: yearsRange, optionsCaption: "Год", selectize: {}',
                        ))?>
                    </div>
                    <?=$form->hiddenField($model, 'birthday')?>
                    <div class="inp-valid_error">
                        <div class="errorMessage"><?php $form->error($model, 'birthday'); ?></div>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
            </div>
        </div>
        <div class="popup-sign_attr">
            <div class="popup-sign_row margin-b30">
                <div class="popup-sign_label">
                    <div class="display-ib">
                        <div class="inp-valid inp-valid__abs">Пол
                            <div class="radio-icons radio-icons__inline margin-l20">
                                <?=$form->radioButtonList($model, 'gender', array(
                                    '1' => 'Мужской',
                                    '0' => 'Женский',
                                ), array(
                                    'separator' => '',
                                    'class' => 'radio-icons_radio',
                                    'data-bind' => 'checked: gender',
                                    'labelOptions' => array(
                                        'class' => 'radio-icons_label',
                                    ),
                                ))?>
                            </div>
                            <div class="inp-valid_error">
                                <?php $form->error($model, 'gender'); ?>
                            </div>
                            <div class="inp-valid_success inp-valid_success__ico-check"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popup-sign_attr">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Код</div>
            </div>
            <div class="popup-sign_row margin-b30">
                <div class="popup-sign_capcha-hold">
                    <?php $this->widget('CCaptcha', array(
                        'buttonLabel' => '<div class="ico-refresh"></div>Обновить</a>',
                        'clickableImage' => true,
                        'imageOptions' => array(
                            'class' => 'popup-sign_capcha',
                        ),
                        'buttonOptions' => array(
                            'class' => 'popup-sign_tx-help',
                        ),
                    )); ?>
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
        </div>
        <div class="popup-sign_row">
            <button class="btn-green-simple btn-l">Продолжить</button>
        </div>
    </div>
</div>