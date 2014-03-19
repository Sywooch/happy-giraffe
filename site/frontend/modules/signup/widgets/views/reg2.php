<?php
/**
 * @var CActiveForm $form
 * @var RegisterFormStep2 $model
 * @todo Выяснить почему пришлось выключить клиентскую валидацию
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
        </div><a class="btn-s btn-blue-simple" data-bind="click: uploadPhoto, text: (avatar.imgSrc() === null) ? 'Загрузить' : 'Изменить'"></a>
    </div>
    <div class="popup-sign_col popup-sign_col__vetical-m">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'registerFormStep2',
            'action' => array('/signup/register/step2'),
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'clientOptions' => array(
                'inputContainer' => 'div.inp-valid',
                'validateOnSubmit' => true,
                'beforeValidate' => 'js:beforeValidateStep2',
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
        <?=CHtml::hiddenField('RegisterFormStep2[service_id]', '', array(
            'data-bind' => 'value: uid',
        ))?>
        <?=CHtml::hiddenField('RegisterFormStep2[service]', '', array(
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
                    <?=$form->dropDownList($model, 'country_id', array(), array(
                        'class' => 'select-cus select-cus__gray',
                        'data-bind' => 'value: location.country_id, options: location.availableCountries, optionsText: "name", optionsValue: "id", optionsCaption: "", select2: location.countrySettings',
                    ))?>
                    <div class="inp-valid_error">
                        <?=$form->error($model, 'country_id')?>
                    </div>
                    <div class="inp-valid_success inp-valid_success__ico-check"></div>
                </div>
                <div class="popup-sign_tx-help">Начинайте вводить название страны...</div>
            </div>
            <div class="popup-sign_row" data-bind="visible: location.country_id">
                <div class="inp-valid inp-valid__abs">
                    <?=$form->hiddenField($model, 'city_id', array(
                        'class' => 'select-cus select-cus__gray',
                        'data-bind' => 'select2: location.citySettings',
                    ))?>
                    <div class="inp-valid_error">
                        <?=$form->error($model, 'city_id')?>
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
                            'data-bind' => 'value: birthday_day.val, options: daysRange, optionsCaption: "", select2: {
                                width: "100%",
                                minimumResultsForSearch: -1,
                                dropdownCssClass: "select2-drop__search-off",
                                escapeMarkup: function(m) { return m; },
                                placeholder: "День"
                            }',
                        ))?>
                    </div>
                    <div class="float-l w-135 margin-r10">
                        <?=$form->dropDownList($model, 'birthday_month', array(), array(
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_month.val, options: monthesRange, optionsCaption: "", optionsText: "name", optionsValue: "id", select2: {
                                width: "100%",
                                minimumResultsForSearch: -1,
                                dropdownCssClass: "select2-drop__search-off",
                                escapeMarkup: function(m) { return m; },
                                placeholder: "Месяц"
                            }',
                        ))?>
                    </div>
                    <div class="float-l w-80">
                        <?=$form->dropDownList($model, 'birthday_year', array(), array(
                            'class' => 'select-cus select-cus__gray',
                            'data-bind' => 'value: birthday_year.val, options: yearsRange, optionsCaption: "", select2: {
                                width: "100%",
                                minimumResultsForSearch: -1,
                                dropdownCssClass: "select2-drop__search-off",
                                escapeMarkup: function(m) { return m; },
                                placeholder: "Год"
                            }',
                        ))?>
                    </div>
                    <?=$form->hiddenField($model, 'birthday')?>
                    <div class="inp-valid_error">
                        <?=$form->error($model, 'birthday')?>
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
                                <?=$form->error($model, 'gender')?>
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
            <button class="btn-green-simple btn-l" data-bind="disable: saving">Продолжить</button>
            <div class="verticalalign-m-el margin-l20" data-bind="visible: saving"><img src="/images/ico/ajax-loader.gif"></div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

