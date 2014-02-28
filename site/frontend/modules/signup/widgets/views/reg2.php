<?php
/**
 * @var CActiveForm $form
 * @var User $model
 */
?>
<div class="popup-sign_top">
    <div class="popup-sign_t">Добро пожаловать, <span data-bind="text: first_name.val"></span>!</div>
    <div class="popup-sign_slogan">Осталось ввести еще немного данных</div>
</div>
<div class="popup-sign_cont">
    <div class="popup-sign_col-ava"><a class="ava ava__large" data-bind="click: uploadPhoto"><span class="ico-status"></span><img alt="" class="ava_img preview-200" data-bind="attr: { src : avatar.imgSrc }"/></a>
        <div class="margin-5">
            <div class="popup-sign_tx-help">Чтобы вас узнавали на Веселом Жирафе <br> загрузите свое главное фото</div>
        </div><a class="btn-s btn-blue-simple" data-bind="click: uploadPhoto">Загрузить</a>
    </div>
    <div class="popup-sign_col popup-sign_col__vetical-m">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registerFormStep2',
            'action' => array('/signup/register/step2'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validateOnSubmit' => true,
                'afterValidate' => 'js:afterValidateStep2',
            ),
        )); ?>
        <?=CHtml::hiddenField('step', '', array(
            'data-bind' => 'value: currentStep',
        ))?>
        <?=CHtml::hiddenField('social', '', array(
            'data-bind' => 'value: social',
        ))?>
        <?=CHtml::hiddenField('userId', '', array(
            'data-bind' => 'value: id',
        ))?>
        <?=CHtml::hiddenField('UserSocialService[service_id]', '', array(
            'data-bind' => 'value: uid',
        ))?>
        <?=CHtml::hiddenField('UserSocialService[service]', '', array(
            'data-bind' => 'value: socialServiceName',
        ))?>
        <div class="popup-sign_attr" data-bind="visible: social() && email.show()">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Адрес активной электронной почты</div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                    <?=$form->textField($model, 'email', array(
                        'class' => 'itx-gray popup-sign_itx',
                        'placeholder' => 'E-mail',
                        'data-bind' => 'value: email.val',
                    ))?>
                    <div class="inp-valid_error">
                        <div class="errorMessage"><?=$form->error($model, 'email')?></div>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
            </div>
        </div>
        <div class="popup-sign_attr" data-bind="visible: social() && (first_name.show() || last_name.show())">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Полное имя</div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                    <?=$form->textField($model, 'first_name', array(
                        'placeholder' => 'Имя',
                        'class' => 'itx-gray popup-sign_itx',
                        'data-bind' => 'value: first_name.val',
                    ))?>
                    <div class="inp-valid_error">
                        <?=$form->error($model, 'first_name')?>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                    <?=$form->textField($model, 'last_name', array(
                        'placeholder' => 'Фамилия',
                        'class' => 'itx-gray popup-sign_itx',
                        'data-bind' => 'value: last_name.val',
                    ))?>
                    <div class="inp-valid_error">
                        <?=$form->error($model, 'last_name')?>
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
        <div class="popup-sign_attr" data-bind="visible: birthday_day.show() || birthday_month.show() || birthday_year.show()">
            <div class="popup-sign_row">
                <div class="popup-sign_label">Дата рождения</div>
            </div>
            <div class="popup-sign_row">
                <div class="inp-valid inp-valid__abs">
                    <div class="float-l w-80 margin-r10">
                        <?=$form->dropDownList($model, 'birthday_day', array(), array(
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_day.val, options: daysRange, optionsCaption: "День", select2: {
                                width: \'100%\',
                                minimumResultsForSearch: -1,
                                dropdownCssClass: \'select2-drop__search-off\',
                                escapeMarkup: function(m) { return m; }
                            }',
                        ))?>
                    </div>
                    <div class="float-l w-135 margin-r10">
                        <?=$form->dropDownList($model, 'birthday_month', array_combine(range(1, 12), array('Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря')), array(
                            'placeholder' => 'Месяц',
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_month.val, options: monthesRange, optionsCaption: "Месяц", optionsText: "name", optionsValue: "id", select2: {
                                width: \'100%\',
                                minimumResultsForSearch: -1,
                                dropdownCssClass: \'select2-drop__search-off\',
                                escapeMarkup: function(m) { return m; }
                            }',
                        ))?>
                    </div>
                    <div class="float-l w-80">
                        <?=$form->dropDownList($model, 'birthday_year', array_combine(range(date('Y') - 16, date('Y') - 90), range(date('Y') - 16, date('Y') - 90)), array(
                            'placeholder' => 'Год',
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_year.val, options: yearsRange, optionsCaption: "Год", select2: {
                                width: \'100%\',
                                minimumResultsForSearch: -1,
                                dropdownCssClass: \'select2-drop__search-off\',
                                escapeMarkup: function(m) { return m; }
                            }',
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
        <div class="popup-sign_attr" data-bind="visible: gender.show">
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
                                    'data-bind' => 'checked: gender.val',
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
        <div class="popup-sign_attr" data-bind="visible: ! social()">
            <div class="margin-b30">
                <div class="popup-sign_row">
                    <?php $this->widget('RegisterCaptcha'); ?>
                </div>
                <div class="popup-sign_row">
                    <!--.popup-sign_capcha-inp-->
                    <div class="inp-valid inp-valid__abs">
                        <?=$form->textField($model, 'verifyCode', array('class' => 'itx-gray popup-sign_itx'))?>
                        <div class="inp-valid_error">
                            <div class="errorMessage"><?=$form->error($model, 'verifyCode')?></div>
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
        <?php $this->endWidget(); ?>
    </div>
</div>

